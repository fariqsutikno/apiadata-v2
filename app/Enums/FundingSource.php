<?php

namespace App\Enums;

enum FundingSource: string
{
    case BIAYA_SENDIRI = 'Biaya Sendiri';
    case BEASISWA = 'Beasiswa';
    case LAINNYA = 'Lainnya';

    public function label(): string
    {
        return match($this) {
            self::BIAYA_SENDIRI => 'Biaya Sendiri',
            self::BEASISWA => 'Beasiswa',
            self::LAINNYA => 'Lainnya',
        };
    }

    public static function labels(): array
    {
        return [
            self::BIAYA_SENDIRI->value => 'Biaya Sendiri',
            self::BEASISWA->value => 'Beasiswa',
            self::LAINNYA->value => 'Lainnya',
        ];
    }
}