<?php

namespace App\Filament\Alumni\Resources\AlumniResource\Pages;

use App\Filament\Alumni\Resources\AlumniResource;
use App\Filament\Alumni\Resources\AlumniResource\RelationManagers\OrganizationAlumnisRelationManager;
use App\Filament\Alumni\Resources\AlumniResource\RelationManagers\UniversityAlumnisRelationManager;
use App\Models\Alumni;
use App\Models\ClassAlumni;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Filament\Actions;
use Filament\Actions\Concerns\InteractsWithRecord;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Njxqlus\Filament\Components\Forms\RelationManager;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    // use InteractsWithRecord;

    protected static string $resource = AlumniResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Profil Saya';

    protected static string $view = 'filament.alumni.resources.alumni-resource.pages.edit-profile';

    // public $activeRelationManager;
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->alumni = Alumni::with('classAlumnis', 'interestAlumnis')->where('nism', '=', auth()->user()->nism)->first();
        if ($this->alumni) {
            // dd($this->alumni);
            $this->form->fill($this->alumni->toArray());
        } else {
            // Handle kasus ketika alumni tidak ditemukan
        }
    }
    
    public function form(Form $form): Form
    {
        return $form
        ->inlineLabel()
        ->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tab::make('Identitas Diri')->schema(self::identitasDiriSchema()),
                    Tab::make('Alamat & Kontak')->schema(self::alamatKontakSchema()),
                    // Tab::make('Riwayat Kelas')->schema(self::studiLanjutSchema()),
                    // Tab::make('Studi Lanjut')->schema([
                    //     RelationManager::make()->manager(UniversityAlumnisRelationManager::class)->lazy(false)
                    // ]),
                    // Tab::make('Pekerjaan')->schema(self::pekerjaanSchema()),
                    // Tab::make('Lain-Lain')->schema(self::lainLainSchema()),
                    // Forms\Components\Tabs\Tab::make('Versions')->schema([
                    //     \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\VersionsRelationManager::class)->lazy(false)
                    // ]),
                    // Forms\Components\Tabs\Tab::make('Stands')->schema([
                    //     \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\StandsRelationManager::class)->lazy(false)
                    // ]),
                    // Forms\Components\Tabs\Tab::make('Contexts')->schema([
                    //     \Njxqlus\Filament\Components\Forms\RelationManager::make()->manager(RelationManagers\ContextsRelationManager::class)->lazy(false)
                    // ]),
                ])->columnSpanFull(),
        ])
        ->statePath('data');
    }

    private static function identitasDiriSchema(): array
    {
        return [
            Section::make('Identitas')
                ->schema([
                    TextInput::make('full_name')
                        ->label('Nama Lengkap')
                        ->required(),
                    TextInput::make('alias')
                        ->label('Nama Panggilan'),
                    TextInput::make('birth_place')
                        ->label('Tempat Lahir')
                        ->required(),
                    DatePicker::make('birth_date')
                        ->label('Tanggal Lahir')
                        ->required(),
                ])->columns(2),
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
        ];
    }
    private static function alamatKontakSchema(): array
    {
        return [
            Section::make('Alamat')
                ->schema([
                    Select::make('country_id')
                        ->label('Negara')
                        ->options(function () {
                            return Cache::remember('countries', 3600, function () {
                                return \App\Models\Country::pluck('name', 'id')->toArray();
                            });
                        })
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
                        ->label('Desa/Kelurahan')
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
                        ->required()
                        ->prefix('https://wa.me/')
                        ->tel()
                        ->maxLength(13)
                        ->helperText('Masukkan kontak orang terdekat yang bisa dihubungi jika dalam keadaan darurat.'),
                    TextInput::make('email')
                        ->required()
                        ->email(),
                    TextInput::make('linkedin')
                        ->url(),
            ])->columns(2),
        ];
    }

    // private static function studiLanjutSchema(): array
    // {
    //     return [
    //         Repeater::make('interests')
    //         ->relationship()
    //         ->schema([
    //             Select::make('interest_id')
    //                 ->relationship('interest','name')
    //                 // ->options(['1' => 'Kamu'])
    //                 ->required(),
    //         ])
    //         ->mutateRelationshipDataBeforeFillUsing(function (array $data): array {
    //             $data['alumni_id'] = $this->alumni['id'];
    //             return $data;
    //         }),
    //     ];
    // }

    private static function pekerjaanSchema(): array
    {
        return [
        ];
    }

    private static function lainLainSchema(): array
    {
        return [
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Update')
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public static function getRelationManagers(): array
    {
        return [
            UniversityAlumnisRelationManager::class,
            // OccupationsRelationManager::class,
            // ClassesRelationManager::class,
            // OrganizationAlumnisRelationManager::class,
            // InterestsRelationManager::class,
        ];
    }

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return false;
    }

    public function update(): void
    {
        $data = $this->form->getState();
        // dd($data);
        Alumni::where('nism', '=', auth()->user()->nism)->update($data);
        Notification::make()
            ->title('Profile updated successfully')
            ->success()
            ->send();
    }
}
