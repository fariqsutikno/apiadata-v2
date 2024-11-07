<?php

namespace App\Filament\Alumni\Resources;

use App\Filament\Alumni\Resources\AlumniResource\Pages;
use App\Filament\Alumni\Resources\AlumniResource\Pages\EditProfile;
use App\Filament\Alumni\Resources\AlumniResource\Pages\ManageStudy;
// use App\Filament\Alumni\Resources\AlumniResource\Pages\EditProfile;
use App\Filament\Alumni\Resources\AlumniResource\RelationManagers;
use App\Filament\Resources\AlumniResource\RelationManagers\ClassesRelationManager;
use App\Filament\Resources\AlumniResource\RelationManagers\InterestsRelationManager;
use App\Filament\Resources\AlumniResource\RelationManagers\OccupationsRelationManager;
use App\Filament\Resources\AlumniResource\RelationManagers\OrganizationAlumnisRelationManager;
use App\Filament\Resources\AlumniResource\RelationManagers\UniversityAlumnisRelationManager;
use App\Models\Alumni;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache as FacadesCache;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationLabel = 'Cari Alumni';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas')
                ->schema([
                    TextInput::make('full_name')
                        ->label('Nama Lengkap (Teks Latin)')
                        ->required(),
                    TextInput::make('arabic_name')
                        ->label('Nama Lengkap (Teks Arab)')
                        ->required(),
                    TextInput::make('alias')
                        ->label('Nama Panggilan'),
                    TextInput::make('birth_place')
                        ->label('Tempat Lahir')
                        ->required(),
                    DatePicker::make('birth_date')
                        ->label('Tanggal Lahir')
                        ->required(),
                ])->columns(3),
            Section::make('Data Diri')
                ->schema([
                    TextInput::make('nik')
                        ->label('NIK')
                        ->numeric()
                        ->minLength(16)
                        ->maxLength(16)
                        ->required()
                        ->unique(ignorable: fn ($record) => $record)
                        ->rules(['regex:/^[0-9]{16}$/']),
                    TextInput::make('nism')
                        ->label('NIS Mahad')
                        ->numeric()
                        ->minLength(6)
                        ->maxLength(10)
                        ->required()
                        ->unique(ignorable: fn ($record) => $record),
                    TextInput::make('nisn')
                        ->label('NISN')
                        ->numeric()
                        ->minLength(10)
                        ->maxLength(10)
                        ->helperText('Sesuaikan dengan ijazah')
                        ->required()
                        ->unique(ignorable: fn ($record) => $record)
                        ->rules(['regex:/^[0-9]{10}$/']),
                    TextInput::make('passport_number')
                        ->label('No Paspor'),
                ])->columns(2),
            Section::make('Data Orang Tua')
                ->schema([
                    TextInput::make('father_name')
                        ->label('Nama Ayah')
                        ->required(),
                    Radio::make('father_status')
                        ->label('Status Ayah')
                        ->options([
                            true => 'Hidup',
                            false => 'Meninggal',
                        ])
                        ->inline()
                        ->default(true)
                        ->required(),
                    TextInput::make('mother_name')
                        ->label('Nama Ibu')
                        ->required(),
                    Radio::make('mother_status')
                        ->label('Status Ibu')
                        ->options([
                            true => 'Hidup',
                            false => 'Meninggal',
                        ])
                        ->inline()
                        ->default(true)
                        ->required(),
                ])->columns(2),
            Section::make('Data Akademik')
                ->schema([
                    TextInput::make('ma_average')
                        ->numeric()
                        ->mask('99.99')
                        ->placeholder('70.00')
                        ->label('Rata-Rata Ijazah MA'),
                    TextInput::make('im_average')
                        ->numeric()
                        ->mask('99.99')
                        ->placeholder('70.00')
                        ->label('Rata-Rata Ijazah IM'),
                    TextInput::make('drive_link')
                        ->label('Link Berkas')
                        ->url()
                        ->required(),
                    TextInput::make('photo_link')
                        ->label('Link Photo')
                        ->url()
                        ->required(),
                ])->columns(2),
                Section::make('Alamat')
                ->schema([
                    Select::make('country_id')
                        ->label('Negara')
                        ->relationship('country', 'name')
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state != 1) { // Asumsi ID 1 untuk Indonesia
                                $set('province_id', null);
                                $set('regency_id', null);
                                $set('district_id', null);
                            }
                        }),

                    Select::make('province_id')
                        ->label('Provinsi')
                        ->searchable()
                        ->reactive()
                        ->visible(fn (callable $get) => $get('country_id') == 1)
                        ->options(function () {
                            return Cache::remember('provinces', 3600, function () {
                                return \App\Models\Province::pluck('name', 'id')->toArray();
                            });
                        })
                        ->afterStateUpdated(fn (callable $set) => $set('regency_id', null)),

                    Select::make('regency_id')
                        ->label('Kabupaten/Kota')
                        ->searchable()
                        ->reactive()
                        ->visible(fn (callable $get) => $get('country_id') == 1)
                        ->options(function (callable $get) {
                            $provinceId = $get('province_id');
                            if (!$provinceId) return [];
                            
                            return Cache::remember("regencies_$provinceId", 3600, function () use ($provinceId) {
                                return \App\Models\Regency::where('province_id', $provinceId)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            });
                        })
                        ->afterStateUpdated(fn (callable $set) => $set('district_id', null)),

                    Select::make('district_id')
                        ->label('Kecamatan')
                        ->searchable()
                        ->visible(fn (callable $get) => $get('country_id') == 1)
                        ->options(function (callable $get) {
                            $regencyId = $get('regency_id');
                            if (!$regencyId) return [];
                            
                            return Cache::remember("districts_$regencyId", 3600, function () use ($regencyId) {
                                return \App\Models\District::where('regency_id', $regencyId)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            });
                        }),

                    Select::make('village_id')
                        ->label('Kelurahan/Desa')
                        ->searchable()
                        ->visible(fn (callable $get) => $get('country_id') == 1)
                        ->options(function (callable $get) {
                            $districtId = $get('district_id');
                            if (!$districtId) return [];
                            
                            return Cache::remember("villages_$districtId", 3600, function () use ($districtId) {
                                return \App\Models\Village::where('district_id', $districtId)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            });
                        }),
                    Textarea::make('address')
                        ->label('Alamat')
                        ->required(),
            ])->columns(2),
            Section::make('Kontak')
                ->schema([
                    TextInput::make('whatsapp')
                        ->required()
                        ->prefix('https://wa.me/')
                        ->tel()
                        ->maxLength(13),
                    TextInput::make('emergency_contact')
                        ->label('Kontak Darurat')
                        ->required()
                        ->prefix('https://wa.me/')
                        ->tel()
                        ->maxLength(13)
                        ->helperText('Masukkan kontak orang terdekat yang bisa dihubungi jika dalam keadaan darurat.'),
                    TextInput::make('email')
                        ->required()
                        ->email(),
                    TextInput::make('linkedin')
                        ->label('Profil Linkedin')
                        ->url(),
            ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                        TextColumn::make('full_name')
                            ->searchable(),
                        TextColumn::make('gen.name'),
                    ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UniversityAlumnisRelationManager::class,
            OccupationsRelationManager::class,
            ClassesRelationManager::class,
            OrganizationAlumnisRelationManager::class,
            InterestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlumnis::route('/'),
            'create' => Pages\CreateAlumni::route('/create'),
            'edit' => Pages\EditAlumni::route('/{record}/edit'),
            'edit-profile' => EditProfile::route('/profile'),
        ];
    }
}
