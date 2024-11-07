<?php

namespace App\Filament\Resources\CompanyFieldResource\Pages;

use App\Filament\Resources\CompanyFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyField extends EditRecord
{
    protected static string $resource = CompanyFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
