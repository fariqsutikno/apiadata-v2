<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterestResource\Pages;
use App\Filament\Resources\InterestResource\RelationManagers;
use Illuminate\Support\Str;
use App\Models\Interest;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class InterestResource extends Resource
{
    protected static ?string $model = Interest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Minat & Bakat';
    protected static ?string $navigationGroup = 'Data Isian';

    public static function getModelLabel(): string
    {
        return 'Minat & Bakat';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Minat & Bakat';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nama Minat')
                    ->required()
                    ->live(onBlur: true)
                    ->unique(Interest::class, 'name', ignoreRecord:true)
                    ->afterStateUpdated(function (string $operation, $state, $set){
                        if($operation !== 'create'){
                            return ;
                        }
                        
                        $set('slug',Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->dehydrated()
                    ->required()
                    ->unique(Interest::class, 'slug', ignoreRecord:true),
                TextInput::make('icon')
                    ->hint(new HtmlString('<a style="color: orange; text-decoration: underline" href="https://heroicons.com/" target="_blank">Cari ikon di sini!</a>')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
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
            'index' => Pages\ListInterests::route('/'),
            'create' => Pages\CreateInterest::route('/create'),
            'edit' => Pages\EditInterest::route('/{record}/edit'),
        ];
    }
}
