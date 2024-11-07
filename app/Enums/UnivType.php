<?php

namespace App\Enums;

enum UnivType: string
{
    case PTN = 'PTN';
    case PTK = 'PTK';
    case PTS = 'PTS';
    case PTM = 'PTM';
    case PTA = 'PTA';
    case PTLN = 'PTLN';

    public static function labels(): array
    {
        return [
            self::PTN->value => 'PT Negeri (PTN)',
            self::PTK->value => 'PT Kedinasan (PTK)',
            self::PTS->value => 'PT Swasta (PTS)',
            self::PTM->value => 'PT Muhammadiyah (PTM)',
            self::PTA->value => 'PT Agama (PTA)',
            self::PTLN->value => 'PT Luar Negeri (PTLN)',
        ];
    }
}