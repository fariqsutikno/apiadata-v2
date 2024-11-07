<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumniResource\Pages;
use App\Filament\Resources\UniversityResource\RelationManagers;
use App\Filament\Resources\UniversityResource\RelationManagers\UniversitiesRelationManager;
use App\Models\Alumni;
use App\Models\District;
use App\Models\Regency;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlumniResource extends Resource
{
    protected static ?string $model = Alumni::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->inlineLabel()
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tab::make('Identitas Diri')
                        ->schema([
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
                                        ->required(),
                                    TextInput::make('nism')
                                        ->label('NIS Mahad')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('nisn')
                                        ->label('NISN')
                                        ->numeric()
                                        ->minLength(10)
                                        ->maxLength(10)
                                        ->helperText('Sesuaikan dengan ijazah')
                                        ->required(),
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
                    ]),
                    Tab::make('Alamat & Kontak')
                        ->schema([
                            Section::make('Alamat')
                                ->schema([
                                    Select::make('country_id')
                                        ->label('Negara')
                                        ->relationship('country', 'name')
                                        ->preload()
                                        ->reactive()
                                        ->searchable()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            // Mengosongkan province dan regency jika negara bukan Indonesia
                                            if ($state != 'ID_INDONESIA') { // Ganti dengan ID yang sesuai untuk Indonesia
                                                $set('province_id', null);
                                                $set('regency_id', null);
                                            }
                                        }),
                                    Select::make('province_id')
                                        ->label('Provinsi')
                                        ->relationship('province', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->reactive()
                                        ->visible(function (callable $get) {
                                            return $get('country_id') == 1; // Ganti dengan ID yang sesuai
                                        })
                                        ->afterStateUpdated(function ($state, callable $set){
                                            $set('regency_id', null);
                                        }),
            
                                    Select::make('regency_id')
                                        ->label('Kabupaten/Kota')
                                        ->relationship('regency', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->visible(function (callable $get) {
                                            return $get('country_id') == 1; // Ganti dengan ID yang sesuai
                                        })
                                        ->options(function (callable $get) {
                                            $provinceId = $get('province_id');
                                            if($provinceId){
                                                return Regency::where('province_id', $provinceId)->pluck('name', 'id');
                                            }
                                            return [];
                                        }),
                                    Select::make('district_id')
                                        ->label('Kecamatan')
                                        ->relationship('district', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->visible(function (callable $get) {
                                            return $get('country_id') == 1; // Ganti dengan ID yang sesuai
                                        })
                                        ->options(function (callable $get) {
                                            $regencyId = $get('regency_id');
                                            if($regencyId){
                                                return District::where('regency_id', $regencyId)->pluck('name', 'id');
                                            }
                                            return [];
                                        }),
                                    Select::make('village_id')
                                        ->label('Desa')
                                        ->relationship('village', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->visible(function (callable $get) {
                                            return $get('country_id') == 1; // Ganti dengan ID yang sesuai
                                        })
                                        ->options(function (callable $get) {
                                            $districtId = $get('district_id');
                                            if($districtId){
                                                return Village::where('district_id', $districtId)->pluck('name', 'id');
                                            }
                                            return [];
                                        }),
                                    Textarea::make('address')
                                        ->columnSpanFull()
                                        ->required()
                                        ->inlineLabel(False),
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
                        ]),
                    Tab::make('Studi Lanjut')
                        ->schema([
                        ]),
                    Tab::make('Pekerjaan')
                        ->schema([

                        ]),
                    Tab::make('Lain-Lain')
                        ->schema([
                            Section::make('Status')
                            ->schema([
                                Toggle::make('is_life'),
                                TextInput::make('account_status'),
                                TextInput::make('marital_status'),
                            ]),
                            Section::make('Kealumnian')
                            ->schema([
                                TextInput::make('predicate'),
                                Select::make('gen_id'),
                                // Select::make('user_id'),
                                // Select::make('alumni_code'),
                                // Select::make('actived_at'),
                            ]),
                        ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            AlumniResource::getRelations()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlumnis::route('/'),
            'create' => Pages\CreateAlumni::route('/create'),
            'edit' => Pages\EditAlumni::route('/{record}/edit'),
        ];
    }
}


use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;

// ...

$endSelect = Select::make('end')
    ->label('Tahun Selesai')
    ->options(function (callable $get) {
        $startYear = $get('start') ?: Carbon::now()->year;
        $currentYear = Carbon::now()->year;
        $endYear = $currentYear + 7;

        $years = array_combine(
            range($startYear, $endYear),
            range($startYear, $endYear)
        );

        return array_merge(
            ['current' => 'Saat Ini'],
            $years
        );
    })
    ->searchable()
    ->required()
    ->rules([
        function (callable $get) {
            return function ($attribute, $value, $fail) use ($get) {
                $startYear = $get('start');
                $currentYear = Carbon::now()->year;

                if ($value === 'current') {
                    return;
                }

                if (!is_numeric($value)) {
                    $fail("Tahun Selesai harus berupa angka atau 'Saat Ini'.");
                    return;
                }

                $value = (int) $value;

                if ($value < $startYear) {
                    $fail("Tahun Selesai harus sama dengan atau lebih besar dari Tahun Mulai.");
                }

                if ($value < 2021) {
                    $fail("Tahun Selesai minimal 2021.");
                }

                if ($value > ($currentYear + 7)) {
                    $fail("Tahun Selesai tidak boleh lebih dari " . ($currentYear + 7) . ".");
                }
            };
        },
    ])
    ->reactive()
    ->afterStateHydrated(function (Select $component, $state) {
        if ($state === null) {
            $component->state('current');
        }
    })
    ->disabled(fn (callable $get) => is_null($get('start')))
    ->dehydrateStateUsing(function ($state) {
        if ($state === 'current') {
            return Carbon::now()->year;
        }
        return $state;
    })
    ->formatStateUsing(function ($state) {
        if ($state == Carbon::now()->year) {
            return 'current';
        }
        return $state;
    })
    ->afterStateUpdated(function ($state, callable $set) {
        $currentYear = Carbon::now()->year;
        
        if ($state === 'current') {
            $set('completion_status', CompletionStatus::SEDANG_BERJALAN);
        } elseif (is_numeric($state) && (int)$state <= $currentYear) {
            // Tidak mengubah status jika sudah diatur
            if (!in_array($set('completion_status'), [CompletionStatus::LULUS, CompletionStatus::BERHENTI])) {
                $set('completion_status', null);
            }
        } else {
            $set('completion_status', CompletionStatus::SEDANG_BERJALAN);
        }
    });

$completionStatusRadio = Radio::make('completion_status')
    ->label('Status Perkuliahan')
    ->options(function (callable $get) {
        $endYear = $get('end');
        $currentYear = Carbon::now()->year;

        if ($endYear === 'current' || (is_numeric($endYear) && (int)$endYear > $currentYear)) {
            return [CompletionStatus::SEDANG_BERJALAN => CompletionStatus::labels()[CompletionStatus::SEDANG_BERJALAN]];
        } else {
            return [
                CompletionStatus::LULUS => CompletionStatus::labels()[CompletionStatus::LULUS],
                CompletionStatus::BERHENTI => CompletionStatus::labels()[CompletionStatus::BERHENTI]
            ];
        }
    })
    ->default(CompletionStatus::SEDANG_BERJALAN)
    ->inline()
    ->inlineLabel(false)
    ->required()
    ->reactive()
    ->disabled(function (callable $get) {
        $endYear = $get('end');
        $currentYear = Carbon::now()->year;
        return $endYear === 'current' || (is_numeric($endYear) && (int)$endYear > $currentYear);
    });

// Gunakan $endSelect dan $completionStatusRadio dalam form Anda

<?php

namespace App\Filament\Alumni\Resources\AlumniResource\Pages;

use App\Filament\Alumni\Resources\AlumniResource;
use App\Models\Alumni;
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
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;
    // use InteractsWithRecord;

    protected static string $resource = AlumniResource::class;

    protected static string $view = 'filament.alumni.resources.alumni-resource.pages.edit-profile';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->alumni = Alumni::where('nism', '=' , auth()->user()->nism)->first();
        $this->form->fill($this->alumni->toArray());
    }

    public function form(Form $form): Form
    {
        dd($this->alumni);
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
        ])
        ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('Update')
                ->color('primary')
                ->submit('Update'),
        ];
    }

    public function submit(): void
    {
        $this->alumni->update($this->form->getState());
    }
}
