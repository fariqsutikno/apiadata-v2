<?php

namespace App\Enums;

enum JobCategory: string
{
    case FULL_TIME = 'Full Time';
    case PART_TIME = 'Part Time';
    case FREELANCE = 'Freelance';
    case KHIDMAH = 'Khidmah';
    case LAINNYA = 'Lainnya';

    public static function labels(): array
    {
        return [
            self::FULL_TIME->value => 'Full Time',
            self::PART_TIME->value => 'Part Time',
            self::FREELANCE->value => 'Freelance',
            self::KHIDMAH->value => 'Khidmah',
            self::LAINNYA->value => 'Lainnya',
        ];
    }
}