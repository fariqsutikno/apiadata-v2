<?php

namespace App\Filament\Resources\GenResource\Pages;

use App\Filament\Resources\GenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGens extends ListRecords
{
    protected static string $resource = GenResource::class;
    protected static ?string $title = 'List Angkatan';

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
