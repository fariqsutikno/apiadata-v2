<?php

namespace App\Filament\Resources\GenResource\Pages;

use App\Filament\Resources\GenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGen extends EditRecord
{
    protected static string $resource = GenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
