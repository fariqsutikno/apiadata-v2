<?php

namespace App\Enums;

enum CompletionStatus: string
{
    case SEDANG_BERJALAN = 'Sedang Berjalan';
    case LULUS = 'Lulus';
    case BERHENTI = 'Berhenti';


    public function label(): string 
    {
        return match($this) {
            self::SEDANG_BERJALAN => 'Sedang Berjalan',
            self::LULUS => 'Lulus',
            self::BERHENTI => 'Berhenti'
        };
    }

    public static function labels(): array
    {
        return [
            self::SEDANG_BERJALAN->value => 'Sedang Berjalan',
            self::LULUS->value => 'Lulus',
            self::BERHENTI->value => 'Berhenti',
        ];
    }
}