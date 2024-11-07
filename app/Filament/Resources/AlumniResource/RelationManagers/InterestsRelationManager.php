<?php

namespace App\Filament\Resources\AlumniResource\RelationManagers;

use App\Models\Interest;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InterestsRelationManager extends RelationManager
{
    protected static string $relationship = 'interests';

    protected static ?string $title = 'Topik Diminati';

    public static function getModelLabel(): string
    {
        return 'Topik yang Diminati';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Topik yang Diminati';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('name')
                    ->label('Topik yang Diminati')
                    ->options(Interest::all()->pluck('name', 'id'))
                    ->required()
                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                ->recordSelect(
                    fn (Select $select) => $select->placeholder('Select a interes'),
                )
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
}
