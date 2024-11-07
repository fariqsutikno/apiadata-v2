<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyFieldResource\Pages;
use App\Filament\Resources\CompanyFieldResource\RelationManagers;
use App\Models\CompanyField;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyFieldResource extends Resource
{
    protected static ?string $model = CompanyField::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('field')
                    ->label('Bidang')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('field')
                    ->label('Bidang')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyFields::route('/'),
            // 'create' => Pages\CreateCompanyField::route('/create'),
            // 'edit' => Pages\EditCompanyField::route('/{record}/edit'),
        ];
    }
}
