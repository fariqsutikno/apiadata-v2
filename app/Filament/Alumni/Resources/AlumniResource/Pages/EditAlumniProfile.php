<?php

namespace App\Filament\Alumni\Resources\AlumniResource\Pages;

use App\Filament\Alumni\Resources\AlumniResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlumniProfile extends EditRecord
{
    protected static string $resource = AlumniResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Profil Saya';

    protected static string $view = 'filament.alumni.resources.alumni-resource.pages.edit-profile';

    
}
