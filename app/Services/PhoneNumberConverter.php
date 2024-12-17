<?php

namespace App\Services;

class PhoneNumberConverter
{
    /**
     * Konversi nomor telepon ke format standar Indonesia
     * 
     * @param string $phoneNumber Nomor telepon yang akan dikonversi
     * @return string Nomor telepon yang sudah diformat
     */
    public static function convert($phoneNumber)
    {
        $cleanedNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Jika diawali dengan 0, ganti dengan 62
        if (strpos($cleanedNumber, '0') === 0) {
            $cleanedNumber = '62' . substr($cleanedNumber, 1);
        }
        
        return $cleanedNumber;
    }
}
