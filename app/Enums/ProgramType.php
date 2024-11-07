<?php

namespace App\Enums;

enum ProgramType: string
{
    case UMUM_MURNI = 'Umum Murni';
    case UMUM_AGAMA = 'Umum Agama';
    case AGAMA = 'Agama';

    public static function labels(): array
    {
        return [
            self::UMUM_MURNI->value => 'Umum Murni',
            self::UMUM_AGAMA->value => 'Umum Agama',
            self::AGAMA->value => 'Agama',
        ];
    }
}