<?php

namespace App\Enums;

enum AdmissionPath: string
{
    case SNBT = 'SNBT';
    case SNBP = 'SNBP';
    case UMPTKIN = 'UMPTKIN';
    case SPANPTKIN = 'SPANPTKIN';
    case JALUR_PRESTASI = 'Jalur Prestasi';
    case MANDIRI = 'Mandiri';
    case KEDINASAN = 'Kedinasan';
    case LAINNYA = 'Lainnya';

    public function label(): string
    {
        return match($this) {
            self::SNBT => 'SNBT',
            self::SNBP => 'SNBP',
            self::UMPTKIN => 'UM PTKIN',
            self::SPANPTKIN => 'SPAN PTKIN',
            self::JALUR_PRESTASI => 'Mandiri Prestasi (Tahfiz, Sertifikat, Organisasi, Minhatee/SIS, Dll.)',
            self::MANDIRI => 'Mandiri Non Prestasi (Tes Mandiri, Biro Jasa, Kader, Dll.)',
            self::KEDINASAN => 'Kedinasan',
            self::LAINNYA => 'Lainnya',
        };
    }

    public static function labels(): array
    {
        return [
            self::SNBT->value => 'SNBT',
            self::SNBP->value => 'SNBP',
            self::UMPTKIN->value => 'UM PTKIN',
            self::SPANPTKIN->value => 'SPAN PTKIN',
            self::JALUR_PRESTASI->value => 'Mandiri Prestasi (Tahfiz, Sertifikat, Organisasi, Minhatee/SIS, Dll.)',
            self::MANDIRI->value => 'Mandiri Non Prestasi (Tes Mandiri, Biro Jasa, Kader, Dll.)',
            self::KEDINASAN->value => 'Kedinasan',
            self::LAINNYA->value => 'Lainnya',
        ];
    }
}