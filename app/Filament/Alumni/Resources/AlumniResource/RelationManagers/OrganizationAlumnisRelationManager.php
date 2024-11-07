<?php

namespace App\Filament\Alumni\Resources\AlumniResource\RelationManagers;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationAlumnisRelationManager extends RelationManager
{
    protected static string $relationship = 'organizationAlumnis';

    protected static ?string $title = 'Riwayat Majma/JT';

    public static function getModelLabel(): string
    {
        return 'Riwayat Majma/JT';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Riwayat Majma/JT';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('organization_id')
                    ->label('Organisasi')
                    ->relationship('organization', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('position')
                    ->label('Posisi/Jabatan')
                    ->required(),
                    Select::make('start')
                    ->label('Tahun Mulai')
                    ->options(function () {
                        return array_combine(
                            range(2018, 2024),
                            range(2018, 2024)
                        );
                    })
                    ->searchable()
                    ->required()
                    ->rules(['integer', 'min:2018', 'max:2024'])
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set('end', null);
                    }),
                    
                    Select::make('end')
                        ->label('Sampai')
                        ->options(function (callable $get) {
                            $startYear = $get('start') ?: Carbon::now()->year;
                            $endYear = $startYear + 3;
                    
                            $years = array_combine(
                                range($startYear, $endYear),
                                range($startYear, $endYear)
                            );
                    
                            return $years;
                        })
                        ->searchable()
                        ->required()
                        ->rules([
                            function (callable $get) {
                                return function ($attribute, $value, $fail) use ($get) {
                                    $startYear = $get('start');
                    
                                    if (!is_numeric($value)) {
                                        $fail("Tahun Selesai harus berupa angka atau 'Saat Ini'.");
                                        return;
                                    }
                    
                                    $value = (int) $value;
                    
                                    if ($value < $startYear) {
                                        $fail("Tahun Selesai harus sama dengan atau lebih besar dari Tahun Mulai.");
                                    }
                                };
                            },
                        ])
                        ->reactive()
                        ->disabled(fn (callable $get) => is_null($get('start'))
                        ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('organization_id')
            ->columns([
                Tables\Columns\TextColumn::make('organization.name')
                    ->label('Nama Organisasi'),
                TextColumn::make('position')
                    ->label('Posisi/Jabatan'),
                TextColumn::make('start')
                    ->label('Tahun Mulai')
                    ->sortable(),
                TextColumn::make('end')
                    ->label('Tahun Akhir'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function hasCombinedRelationManagerTabsWithContent()
    {
        return true;
    }
}
