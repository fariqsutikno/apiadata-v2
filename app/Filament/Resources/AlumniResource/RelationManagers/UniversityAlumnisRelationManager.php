<?php

namespace App\Filament\Resources\AlumniResource\RelationManagers;

use App\Enums\AdmissionPath;
use App\Enums\CompletionStatus;
use App\Enums\Degree;
use App\Enums\FundingSource;
use App\Models\Program;
use Carbon\Carbon;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class UniversityAlumnisRelationManager extends RelationManager
{
    protected static string $relationship = 'universityAlumnis';

    protected static ?string $recordTitleAttribute = 'university_id';

    protected static ?string $title = 'Riwayat Studi Lanjut';

    public static function getModelLabel(): string
    {
        return 'Riwayat Studi Lanjut';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Riwayat Studi Lanjut';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('university_id')
                    ->label('Universitas')
                    ->options(function () {
                        return Cache::remember('universities_list', now()->addHour(), function () {
                            return DB::table('universities')
                                ->select('id', 'name')
                                ->orderBy('name')
                                ->get()
                                ->pluck('name', 'id')
                                ->toArray();
                        });
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('program_id', null)),
        
                Select::make('program_id')
                    ->label('Program Studi')
                    ->options(function (callable $get) {
                        $universityId = $get('university_id');
                        if (!$universityId) return [];
        
                        return Cache::remember("programs_for_university_{$universityId}", now()->addMinutes(30), function () use ($universityId) {
                            return DB::table('programs')
                                ->select('id', 'name')
                                ->where('university_id', $universityId)
                                ->orderBy('name')
                                ->get()
                                ->pluck('name', 'id')
                                ->toArray();
                        });
                    })
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->disabled(fn (callable $get) => !$get('university_id'))
                    ->dehydrated(fn ($state) => filled($state))
                    ->preload(false),

                Select::make('start')
                    ->label('Tahun Mulai')
                    ->options(function () {
                        return array_combine(
                            range(2021, Carbon::now()->year),
                            range(2021, Carbon::now()->year)
                        );
                    })
                    ->searchable()
                    ->required()
                    ->rules(['integer', 'min:2021', 'max:' . Carbon::now()->year])
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set('end', null);
                    }),
                    
                    Select::make('end')
                        ->label('Sampai')
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
                                        return; // Validasi lolos jika "Saat Ini" dipilih
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
                        }),
                
                
                        Select::make('admission_path')
                        ->label('Jalur Penerimaan')
                        ->options(AdmissionPath::labels())
                        ->required()
                        ->live() // Ini penting! Untuk membuat field reaktif terhadap perubahan
                        ->afterStateUpdated(function ($state, callable $set) {
                            // Jika bukan SNBT, kosongkan nilai snbt_score
                            if ($state !== 'SNBT') {
                                $set('snbt_score', null);
                            }
                        }),
                    
                    TextInput::make('snbt_score')
                        ->label('Nilai SNBT')
                        ->numeric()
                        ->visible(fn (Get $get) => $get('admission_path') === 'SNBT') // Field hanya muncul jika admission_path = SNBT
                        ->required(fn (Get $get) => $get('admission_path') === 'SNBT'), // Wajib diisi hanya jika admission_path = SNBT
                    
                
                Group::make()
                        ->schema([
                            Radio::make('completion_status')
                                ->label('Status Perkuliahan')
                                ->options(CompletionStatus::labels())
                                ->default(CompletionStatus::SEDANG_BERJALAN)
                                ->inline()
                                ->inlineLabel(false)
                                ->required(),
            
                            Radio::make('funding_source')
                                ->label('Sumber Pendanaan')
                                ->options(FundingSource::labels())
                                ->default(FundingSource::BIAYA_SENDIRI)
                                ->inline()
                                ->inlineLabel(false)
                                ->required(),
                        ]),
                Hidden::make('is_accepted')->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('university.name')
                    ->label('Nama Univ')
                    ->sortable(),
                TextColumn::make('program.name')
                    ->label('Nama Prodi')
                    ->sortable(),
                TextColumn::make('program.degree')
                    ->label('Jenjang')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('start')
                    ->label('Mulai')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('end')
                    ->label('Sampai')
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('is_accepted')
                    ->label('Diterima')
                    ->boolean(),
                TextColumn::make('admission_path')
                    ->label("Jalur Penerimaan")
                    ->toggleable(),
                TextColumn::make('completion_status')
                    ->label('Status Perkuliahan')
                    ->badge()
                    ->color(fn (CompletionStatus|string $state): string => match ($state) {
                        CompletionStatus::SEDANG_BERJALAN, 'SEDANG_BERJALAN' => 'warning',
                        CompletionStatus::LULUS, 'LULUS' => 'success',
                        CompletionStatus::BERHENTI, 'BERHENTI' => 'gray',
                        default => 'gray',
                    })
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('completion_status')
                    ->options(CompletionStatus::labels())
                    ->multiple()
                    ->searchable(),
                // Tables\Filters\BooleanFilter::make('is_accepted')
                //     ->label('Diterima'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}