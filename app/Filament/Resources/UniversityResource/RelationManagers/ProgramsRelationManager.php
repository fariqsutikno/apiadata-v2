<?php

namespace App\Filament\Resources\UniversityResource\RelationManagers;

use App\Enums\Degree;
use App\Enums\ProgramType;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\Regency;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProgramsRelationManager extends RelationManager
{
    protected static string $relationship = 'programs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Prodi')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Prodi')
                            ->required()
                            ->maxLength(255),
                        Select::make('degree')
                            ->label('Jenjang Prodi')
                            ->options(Degree::class),
                        Select::make('program_type')
                            ->label('Kategori Prodi')
                            ->options(ProgramType::labels())
                            ->enum(ProgramType::class),
                        Select::make('category_id')
                            ->label('Rumpun Ilmu')
                            ->relationship('category', 'name')
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                    if ($operation !== 'create') {
                                        return;
                                    }
                                    
                                    $set('slug', Str::slug($state));
                                }),
                            
                                Hidden::make('slug')
                            ])
                            ->createOptionAction(function (Action $action) {
                                return $action
                                    ->modalHeading('Buat Kategori Baru')
                                    // ->modalButton('Simpan Kategori')
                                    ->modalWidth('md');
                            })
                            ->searchable(),
                    ])->columns(2),
                Section::make('Lokasi Kampus')
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
                    ])->columns(3)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('degree')
                    ->label('Jenjang')
                    ->sortable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->getStateUsing(function ($record) {
                        if ($record->regency_id) {
                            return $record->regency->name ?? '-';
                        } else {
                            return $record->country->name ?? '-';
                        }
                    })
            ])
            ->filters([
                SelectFilter::make('degree')
                    ->options(Degree::class)
                    ->multiple(),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->preload()
                    ->multiple(),
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
}
