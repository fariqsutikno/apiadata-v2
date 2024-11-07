<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Filament\Resources\ClassroomResource\RelationManagers;
use App\Models\Classroom;
use App\Models\Gen;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kelas';

    public static function getModelLabel(): string
    {
        return 'Kelas';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kelas';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('class')
                    ->label('Nama Kelas')
                    ->minLength(3)
                    ->maxLength(3)
                    ->required(),
                Select::make('year')
                    ->required()
                    ->label('Tahun Ajaran')
                    ->options([
                        2019 => '2018/2019',
                        2020 => '2019/2020',
                        2021 => '2020/2021',
                        2022 => '2021/2022',
                        2023 => '2022/2023',
                        2024 => '2023/2024',
                    ]),
                TextInput::make('teacher')
                    ->label('Wali Kelas')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('class'),
                TextColumn::make('year'),
                TextColumn::make('teacher'),
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
            'index' => Pages\ListClassrooms::route('/'),
            // 'create' => Pages\CreateClassroom::route('/create'),
            // 'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
