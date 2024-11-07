<?php

namespace App\Filament\Resources\CompanyFieldResource\Pages;

use App\Filament\Resources\CompanyFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyFields extends ListRecords
{
    protected static string $resource = CompanyFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
