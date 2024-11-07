<?php

namespace App\Filament\Resources;

use App\Enums\UnivType;
use App\Filament\Resources\UniversityResource\Pages;
use App\Filament\Resources\UniversityResource\RelationManagers;
use App\Filament\Resources\UniversityResource\RelationManagers\ProgramsRelationManager;
use App\Models\University;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UniversityResource extends Resource
{
    protected static ?string $model = University::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Data Perguruan Tinggi';

    public static function getModelLabel(): string
    {
        return 'Perguruan Tinggi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Perguruan Tinggi';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Data Utama Kampus')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama PT')
                                    ->helperText('Tuliskan nama lengkap kampus di sini. Seperti Universitas Gadjah Mada, dst. Sesuaikan dengan data PD Dikti')
                                    ->required(),
                                TextInput::make('alias')
                                    ->label('Nama Alias')
                                    ->helperText('Tuliskan nama populer atau singkatan di sini. Seperti UGM, Undip, dst. Kolom ini untuk memudahkan pencarian nantinya.')
                                    ->required(),
                                FileUpload::make('logo')
                                    ->label('Logo Kampus')
                                    ->image()
                                    ->avatar()
                                    ->imageEditor()
                                    ->circleCropper()
                                    ->preserveFilenames()
                                    ->directory('kampus'),
                                Select::make('univ_type')
                                    ->options(UnivType::labels())
                                    ->enum(UnivType::class)
                                    ->label('Tipe Kampus')
                                    ->required(),
                        ]),
                    ]),
                Group::make()
                ->schema([
                    Section::make('Status Kampus')
                        ->schema([
                            Toggle::make('is_featured')
                                ->label('Kampus Unggulan?')
                                ->default(false),
                    ]),
                ]),
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
                    TextColumn::make('name')
                        ->weight(FontWeight::Bold)
                        ->searchable(['name', 'alias'])
                        // ->modifySearchableTableQuery(function (Builder $query, string $search) {
                        //     return $query->where('name', 'like', "%{$search}%")
                        //                  ->orWhere('alias', 'like', "%{$search}%");
                        // })
                        ->description(function ($record){
                            $jumlahProdi = $record->programs->count();
                            $jumlahRumpun = $record->programs()->distinct('category_id')->count('category_id');
                            return "{$jumlahProdi} Program Studi | {$jumlahRumpun} Rumpun Ilmu";
                        }),
                ])
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
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
            ProgramsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUniversities::route('/'),
            'create' => Pages\CreateUniversity::route('/create'),
            'edit' => Pages\EditUniversity::route('/{record}/edit'),
        ];
    }
}
