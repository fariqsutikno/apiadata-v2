<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;
use Illuminate\Support\Str;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use League\CommonMark\Input\MarkdownInput;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'Majma & JT';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Majma & JT';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nama Majma')
                    ->required()
                    ->live(onBlur: true)
                    ->unique(Organization::class, 'name', ignoreRecord:true)
                    ->afterStateUpdated(function (string $operation, $state, $set){
                        if($operation !== 'create'){
                            return ;
                        }
                        
                        $set('slug',Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->dehydrated()
                    ->required()
                    ->unique(Organization::class, 'slug', ignoreRecord:true),
                Textarea::make('description'),
                FileUpload::make('logo')
                    ->image()
                    ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->preserveFilenames()
                    ->directory('majma'),
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
                    ->searchable()
                    ->description(fn (Organization $record): string => $record->description ? $record->description :"-" ),
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOrganizations::route('/'),
            // 'create' => Pages\CreateOrganization::route('/create'),
            // 'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
