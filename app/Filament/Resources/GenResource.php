<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenResource\Pages;
use App\Filament\Resources\GenResource\RelationManagers;
use App\Models\Gen;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GenResource extends Resource
{
    protected static ?string $model = Gen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Angkatan';

    public static function getModelLabel(): string
    {
        return 'Angkatan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Angkatan';
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    ImageColumn::make('logo')
                        ->size(60)
                        ->circular(),
                        // ->grow(false),
                    TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->description(fn (Gen $record): string => $record->year . ' | ' . $record->leader),
                ])

            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->paginated(false)
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListGens::route('/'),
            // 'create' => Pages\CreateGen::route('/create'),
            'edit' => Pages\EditGen::route('/{record}/edit'),
        ];
    }
}
