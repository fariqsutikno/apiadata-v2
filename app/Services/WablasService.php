<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WablasService
{

    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $this->apiUrl = 'https://tegal.wablas.com/api/send-message';
        $this->token = config('services.wablas.token');
    }

    public function sendOTP($phone, $otp)
    {
        try {
            $message = "Ini adalah pesan otomatis dari *Portal Sidata+*. \n\n Kode OTP Anda adalah: {$otp}. \n\n Berlaku 5 menit. Jangan berikan kode ini ke orang lain.";

            $response = Http::withHeaders([
                'Authorization' => $this->token
            ])->post($this->apiUrl, [
                'token' => $this->token,
                'phone' => $phone,
                'message' => $message
            ]);

            // Logging untuk monitoring
            if (!$response->successful()) {
                \Illuminate\Support\Facades\Log::error('Wablas OTP Send Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'token' => $this->token,    
                    'phone' => $phone,
                ]);
            }

            Log::info('Wablas Request', [
                'url' => $this->apiUrl,
                'headers' => ['Authorization' => $this->token],
                'body' => [
                    'phone' => $phone,
                    'message' => $message,
                    'token' => $this->token
                ]
            ]);

            return $response->successful();

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Wablas OTP Send Failed', [
                'message' => $e->getMessage(),
                'phone' => $phone
            ]);

            return false;
        }
    }


}
