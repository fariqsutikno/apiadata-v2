<?php

namespace App\Filament\Resources\AlumniResource\RelationManagers;

use App\Enums\JobCategory;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OccupationsRelationManager extends RelationManager
{
    protected static string $relationship = 'occupations';

    protected static ?string $title = 'Riwayat Pekerjaan';

    public static function getModelLabel(): string
    {
        return 'Riwayat Pekerjaan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Riwayat Pekerjaan';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 'job_title',
                // 'company_name',
                // 'company_field',
                // 'job_category',
                // 'start',
                // 'end',
                // 'is_khidmah',
                // 'alumni_id',
                Forms\Components\TextInput::make('company_name')
                    ->label('Nama Perusahaan/Kantor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('job_title')
                    ->label('Posisi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('company_field')
                    ->label('Bidang Perusahaan')
                    ->relationship('companyFields','field')
                    ->required(),
                Forms\Components\Select::make('job_category')
                    ->label('Tipe Pekerjaan')
                    ->options(JobCategory::labels())
                    ->required(),
                Forms\Components\Select::make('start')
                    ->label('Tahun Mulai Bekerja')
                    ->options(function (){
                        return array_combine(
                            range(2021, Carbon::now()->year),
                            range(2021, Carbon::now()->year)
                        );
                    })
                    ->required(),
                Forms\Components\Select::make('end')
                    ->label('Tahun Selesai')
                    ->helperText('Kosongkan jika masih bekerja')
                    ->options(function (){
                        return array_combine(
                            range(2021, Carbon::now()->year),
                            range(2021, Carbon::now()->year)
                        );
                    })
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('job_title')
            ->columns([
                TextColumn::make('job_title')
                    ->label('Posisi'),
                TextColumn::make('company_name')
                    ->label('Tempat Bekerja'),
                TextColumn::make('companyFields.field')
                    ->toggleable()
                    ->label('Bidang'),
                TextColumn::make('job_category')
                    ->label('Kategori')
                    ->toggleable()
                    ->badge(),
                TextColumn::make('start')
                    ->label('Mulai')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('end')
                    ->label('Sampai')
                    ->toggleable()
                    ->sortable()
                    ->state(function ($record) {
                        return $record->end ?: 'Sekarang';
                    }),
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
    
}
