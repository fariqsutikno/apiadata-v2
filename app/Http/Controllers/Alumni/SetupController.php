<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Otp;
use App\Services\PhoneNumberConverter;
use App\Services\WablasService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SetupController extends Controller
{
    protected $wablasService;

    public function __construct(WablasService $wablasService)
    {
        $this->wablasService = $wablasService;
    }

    public function formWhatsapp()
    {
        return view('auth.otp.whatsapp');
    }

    public function requestOtp(Request $request)
    {
        try {
            $request->validate([
                'whatsapp' => 'required'
            ]);

            $alumni = Auth::user()->alumni;

            // ubah nomor inputan
            $whatsapp = PhoneNumberConverter::convert($request->whatsapp);

            // Nonaktifkan OTP yang lama untuk alumni ini
            Otp::where('alumni_id', $alumni->id)
            ->where('is_actived', true)
            ->update(['is_actived' => false]);

            // Reset nomor whatsapp alumni
            $alumni->update(['whatsapp' => 'Kosong']);

            //kita siapkan otp mereka
            $otp = sprintf("%06d", mt_rand(1, 999999));
            $otpExpiry = now()->addMinutes(10);
            $tempToken = Str::random(40);

            //kita simpan data otp mereka
            Otp::create([
                'alumni_id' => $alumni->id,
                'whatsapp' => $whatsapp,
                'otp' => $otp,
                'expired_at' =>$otpExpiry,
            ]);

            $otpData = [
                'whatsapp' => $whatsapp,
                'otp' => $otp,
                'resend_attempts' => 0,  // Inisiasi awal
                'last_resend_time' => now()->toDateTimeString()  // Waktu pertama kali dibuat
            ];

            
            Cache::put($tempToken, $otpData, $otpExpiry);
            // dd(Cache::get($tempToken));
    
            //kirim data otp ini ke nomor mereka
            $this->wablasService->sendOtp($whatsapp, $otp);
    
    
            return redirect()->route('setup.otp.form', ['token' => $tempToken])
            ->with('success', 'Kode OTP telah dikirim. Coba cek WhatsApp kamu!');


        } catch (ValidationException $e) {
            // Tangani kesalahan validasi
            return back()
                ->withErrors($e->validator)
                ->withInput();
    
        } catch (Exception $e) {
            // Tangani kesalahan umum
            Log::error('Kesalahan pada proses OTP: ' . $e->getMessage());
    
            return back()
                ->with('error', 'Terjadi kesalahan. Mohon cek kembali nomor Anda atau hubungi dukungan.');
        }
    }

    public function formOtp($token)
    {
        // $tempToken = $request->route('token');
        // dd($tempData);
        // Pastikan temporary token valid
        if (!Cache::has($token)) {
            return redirect()->route('setup.otp.whatsapp')->with('error', 'Token tidak valid atau sudah kadaluarsa');
        }
        
        $tempCache = Cache::get($token);
        $whatsapp = $tempCache['whatsapp'];
        

        return view('auth.otp.verify', compact('token', 'whatsapp'));
    }

    public function verifyOtp(Request $request)
    {
        $alumni = Auth::user()->alumni;
        $otpData = Otp::where('alumni_id', $alumni->id)
                    ->where('verified_at', null)
                    ->where('is_actived', 0)
                    ->latest()
                    ->first();
        
        $tempToken = $request->input('token');
        $otpInput = implode('', [
            $request->otp1,
            $request->otp2,
            $request->otp3,
            $request->otp4,
            $request->otp5,
            $request->otp6
        ]);

        // Ambil data dari cache
        $otpCache = Cache::get($tempToken);
        // dd($otpCache);

        // Kalau ternyata data gaada di cache atau database atau sudah expire
        if(!$otpData || !$otpCache || $otpData->expired_at < now()){
            return redirect()->route('setup.otp.whatsapp')->with('error', 'Token tidak valid atau sudah kadaluarsa. Silakan ajukan kembali');
        }

        if ($otpData->otp !== $otpInput && $otpCache['otp'] !== $otpInput) {
            return back()
            ->with('error', 'OTP salah!');
        }

        // Bandingkan OTP
        if ($otpData->otp === $otpInput && $otpCache['otp'] === $otpInput) {
            // Hapus token setelah verifikasi berhasil
            Cache::forget($tempToken);

            $otpData->update([
                'verified_at' => now(),
                'is_actived' => 1,
            ]);
    
            $alumni->whatsapp = $otpData->whatsapp;
            $alumni->account_status = 'Aktif';
            $alumni->save();

            // Lakukan proses setelah verifikasi (contoh: login)
            return redirect()->route('dashboard')->with('success', 'Verifikasi berhasil');
        }
    }

    public function resendOtp(Request $request)
    {
        $tempToken = $token ?? $request->input('token');
        // dd($tempToken);

        $alumni_id = Auth::user()->alumni->id;

        // Ambil data dari cache
        $otpCache = Cache::get($tempToken);

        if (!$otpCache) {
            return redirect()->route('setup.otp.whatsapp')->with('error', 'Token tidak valid atau sudah kadaluarsa. Silakan ajukan kembali.');
        }

        // Tambahkan logika penundaan resend
        $resendAttempts = $otpCache['resend_attempts'] ?? 0;
        $lastResendTime = $otpCache['last_resend_time'] ?? null;

        // Hitung waktu penundaan berdasarkan jumlah percobaan
        $delaySeconds = $resendAttempts == 0 ? 60 : 120;

        // dd([$resendAttempts, $lastResendTime, $delaySeconds, now()->diffInMinutes(Carbon::parse($lastResendTime))]);

        // Cek apakah sudah bisa resend
        if ($lastResendTime) {
            $elapsedSeconds = now()->diffInSeconds(Carbon::parse($lastResendTime));
            // dd($lastResendTime, now(), $elapsedSeconds, $delaySeconds);
            
            // Jika waktu yang telah berlalu kurang dari waktu tunggu yang ditentukan
            if ($elapsedSeconds * -1 < $delaySeconds) {
                $remainingSeconds = round($delaySeconds + $elapsedSeconds);
                return back()->with('error', "Silakan tunggu {$remainingSeconds} detik lagi untuk mengirim ulang OTP");
            }
        }

        $whatsapp = $otpCache['whatsapp'];

        // Generate OTP baru
        $newOtp = sprintf("%06d", mt_rand(1, 999999));
        $newOtpExpiry = now()->addMinutes(10);

        // Update data di cache
        $newOtpCache = [
            'whatsapp' => $whatsapp,
            'otp' => $newOtp,
            'resend_attempts' => $resendAttempts + 1,
            'last_resend_time' => now()->toDateTimeString()
        ];
        
        // dd($newOtpCache);
        Cache::put($tempToken, $newOtpCache, $newOtpExpiry);

        //kita simpan data otp mereka
        Otp::create([
            'alumni_id' => $alumni_id,
            'whatsapp' => $whatsapp,
            'otp' => $newOtp,
            'expired_at' =>$newOtpExpiry,
        ]);

        // Kirim ulang OTP
        $this->wablasService->sendOtp($whatsapp, $newOtp);

        return back()->with('success', 'OTP berhasil dikirim ulang');
    }

    public function changeNumber(Request $request)
    {
        $tempToken = $request->input('token');
        Cache::forget($tempToken);

        return redirect()->route('setup.otp.whatsapp')->with('success', 'Silakan ganti nomor Anda');
    }

    /**
     * Menampilkan form ubah password
     */
    public function showChangePasswordForm()
    {
        $user = Auth::user();
        $name = Auth::user()->alumni->full_name;
        
        // Pastikan user adalah alumni
        // if (!$user->alumni) {
        //     return redirect()->route('dashboard');
        // }

        // Ambil tanggal lahir alumni
        $birthDate = $user->alumni->birth_date;
        $defaultPassword = Carbon::parse($birthDate)->format('dmY');
        // $defaultPassword = '123';

        // Pastikan hanya bisa diakses jika password masih default
        // if (!Hash::check($defaultPassword, $user->password)) {
        //     return redirect()->route('dashboard');
        // }

        return view('alumni.change-password', compact('name'), [
            'mustChangePassword' => true,
        ]);
    }

    /**
     * Proses perubahan password
     */
    public function changePassword(Request $request)
    {
        // dd($request);
        $user = Auth::user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'different:current_password',
                // Tambahan aturan password sesuai kebutuhan
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ], [
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.different' => 'Password baru harus berbeda dengan password saat ini.',
            'new_password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil tanggal lahir alumni sebagai password default
        $birthDate = $user->alumni->birth_date;
        $defaultPassword = Carbon::parse($birthDate)->format('dmY');

        // Periksa apakah password saat ini adalah password default
        $isDefaultPassword = Hash::check($defaultPassword, $user->password);

        // Jika bukan password default, periksa kecocokan password saat ini
        if (!$isDefaultPassword && !Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors([
                'current_password' => 'Password saat ini salah.'
            ]);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Redirect dengan pesan sukses
        // return redirect()->route('dashboard')->with('success', 'Password berhasil diubah.');
        return redirect()->route('setup.otp.whatsapp')->with('success', 'Password berhasil diubah.');
    }
}
