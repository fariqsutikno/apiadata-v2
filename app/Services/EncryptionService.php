<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class EncryptionService
{

    public function encrypt($value)
    {
        try {
            if ($value === null) {
                return null;
            }
            
            Log::info('Enkripsi data', ['tipe' => gettype($value)]);
            return Crypt::encryptString((string) $value);
        } catch (\Exception $e) {
            Log::error('Gagal enkripsi', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function decrypt($encryptedValue)
    {
        try {
            if ($encryptedValue === null) {
                return null;
            }
            
            return Crypt::decryptString($encryptedValue);
        } catch (\Exception $e) {
            Log::warning('Gagal dekripsi', ['error' => $e->getMessage()]);
            return null;
        }
    }



}
