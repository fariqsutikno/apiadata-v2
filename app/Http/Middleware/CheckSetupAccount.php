<?php

namespace App\Http\Middleware;

use App\Models\Otp;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class CheckSetupAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan user sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Pastikan user adalah alumni
            if ($user->alumni) {
                // Ambil tanggal lahir alumni
                $birthDate = $user->alumni->birth_date;
                $defaultPassword = Carbon::parse($birthDate)->format('dmY');

                // Periksa apakah password masih default
                if (Hash::check($defaultPassword, $user->password)) {
                    // Jika masih menggunakan password default, arahkan ke halaman ubah password
                    return redirect()->route('setup.password.form')->with('mustChangePassword', true);
                }
            }

            // Pastikan data no telpon sudah ada
            $alumniId = $user->alumni->id;

            // cari di tabel otp yang punya ketentuan berikut
            $otpCount = Otp::where('alumni_id', $alumniId)
            ->where('is_actived', 1)
            ->whereNotNull('verified_at')
            ->count();

            $whatsapp = $user->alumni->whatsapp;

            // kalau data di tabel otp kosong, dan di whatsapp isinya "Kosong"
            if ($whatsapp === 'Kosong' || $otpCount === 0) {
                // diarahkan ke halaman verifikasi no telp
                return redirect()->route('setup.otp.whatsapp'); 
            }

        }

        return $next($request);
    }
}
