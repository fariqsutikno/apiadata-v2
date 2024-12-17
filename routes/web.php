<?php

use App\Http\Controllers\Alumni\AlumniController;
use App\Http\Controllers\Alumni\CommunityController;
use App\Http\Controllers\Alumni\InterestController;
use App\Http\Controllers\Alumni\OrganisasiController;
use App\Http\Controllers\Alumni\OtpController;
use App\Http\Controllers\Alumni\PasswordController;
use App\Http\Controllers\Alumni\ProfileController;
use App\Http\Controllers\Alumni\RiwayatAkademikController;
use App\Http\Controllers\Alumni\SetupController;
use App\Http\Controllers\Alumni\StudiController;
use App\Http\Controllers\Alumni\SurveyController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfileController;

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

// Rute yang memerlukan autentikasi
Route::middleware('auth', 'checkSetupAccount')->group(function () {
    // Home
    Route::get('/', [AlumniController::class, 'index'])->name('dashboard');

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('settings');
        Route::get('/identitas', [ProfileController::class, 'editIdentitas'])->name('settings.identitas');
        Route::post('/identitas', [ProfileController::class, 'updateIdentitas'])->name('settings.identitas.update');
    
        Route::get('/studi', [StudiController::class, 'index'])->name('settings.studi.index');
        
        Route::get('/studi/create', function () {
            return view('alumni.settings.studi.create', ['id' => null, 'method' => 'create@studi']);
        })->name('settings.studi.create');

        Route::get('/studi/{id}/edit', function ($id) {
            return view('alumni.settings.studi.create', ['id' => $id, 'method' => 'edit@studi']);
        })->name('settings.studi.edit');

        // Route::get('/studi/create', [StudiController::class, 'create'])->name('settings.studi.create');
        // Route::post('/studi/create', [StudiController::class, 'store'])->name('settings.studi.store');
        // Route::get('/studi/edit/{studi}', [StudiController::class, 'edit'])->name('settings.studi.edit');
        // Route::put('/studi/edit/{studi}', [StudiController::class, 'update'])->name('settings.studi.update');
        
        Route::get('/pekerjaan', [ProfileController::class, 'editPekerjaan'])->name('settings.pekerjaan');
        Route::post('/pekerjaan', [ProfileController::class, 'updatePekerjaan'])->name('settings.pekerjaan.update');
        
        Route::get('/riwayat-akademik', [RiwayatAkademikController::class, 'index'])->name('settings.akademik.index');
        Route::get('/riwayat-akademik/edit', [RiwayatAkademikController::class, 'edit'])->name('settings.akademik.edit');
        Route::put('/riwayat-akademik/edit', [RiwayatAkademikController::class, 'update'])->name('settings.akademik.update');
        
        Route::get('/interest', [InterestController::class, 'index'])->name('settings.interest.index');
        Route::get('/interest/edit', [InterestController::class, 'edit'])->name('settings.interest.edit');
        Route::put('/interest/edit', [InterestController::class, 'update'])->name('settings.interest.update');
        
        Route::get('/organisasi', [OrganisasiController::class, 'index'])->name('settings.organisasi.index');
        Route::get('/organisasi/create', [OrganisasiController::class, 'create'])->name('settings.organisasi.create');
        Route::post('/organisasi/create', [OrganisasiController::class, 'store'])->name('settings.organisasi.store');
        Route::get('/organisasi/edit/{id}', [OrganisasiController::class, 'edit'])->name('settings.organisasi.edit');
        Route::put('/organisasi/edit/{id}', [OrganisasiController::class, 'update'])->name('settings.organisasi.update');
        Route::delete('/organisasi/delete/{id}', [OrganisasiController::class, 'destroy'])->name('settings.organisasi.destroy');
        Route::redirect('/organisasi/{id}', '/settings/organisasi/edit/{id}');
        
        Route::get('/kebijakan-privasi', [ProfileController::class, 'showKebijakanPrivasi'])->name('settings.privasi');
    });

    Route::prefix('komunitas')->group(function () {
        Route::get('/', [CommunityController::class, 'index'])->name('community');
        Route::get('/{category}', [CommunityController::class, 'category'])->name('community.category');
        Route::get('/{category}/{komunitas}', [CommunityController::class, 'profile'])->name('community.detail');
    });

    // Search
    Route::get('/search', [AlumniController::class, 'search'])->name('alumni.search');

    // Profile
    Route::get('/profile/{kodeAlumni}', [AlumniController::class, 'profile'])->name('alumni.detail');

    // Survey
    Route::prefix('survey')->group(function () {
        Route::get('/', [SurveyController::class, 'index'])->name('survey.index');
        Route::get('/first', [SurveyController::class, 'showFirst'])->name('survey.first.show');
        Route::post('/first', [SurveyController::class, 'storeFirst'])->name('survey.first.store');
        Route::get('/studi', [SurveyController::class, 'listSecond'])->name('survey.studi.index');
        // Route::get('/{kodeSurvey}', [SurveyController::class, 'show'])->name('survey.show');
        // Route::post('/{kodeSurvey}/submit', [SurveyController::class, 'submit'])->name('survey.submit');
        Route::get('/studi/create', function () {
            return view('alumni.settings.studi.create', ['id' => null, 'method' => 'create@survey']);
        })->name('survey.studi.create');

        Route::get('/studi/{id}/edit', function ($id) {
            return view('alumni.settings.studi.create', ['id' => $id, 'method' => 'edit@survey']);
        })->name('survey.studi.edit');
    });

    // Kategori
    Route::prefix('kategori')->group(function () {
        // Kampus
        Route::get('/kampus', [AlumniController::class, 'showKampus'])->name('kategori.kampus');
        Route::get('/kampus/{kodeKampus}', [AlumniController::class, 'showAlumniByKampus'])->name('kategori.kampus.alumni');

        // Angkatan
        Route::get('/angkatan', [AlumniController::class, 'showAngkatan'])->name('kategori.angkatan');
        Route::get('/angkatan/{tahun}', [AlumniController::class, 'showAlumniByAngkatan'])->name('kategori.angkatan.alumni');

        // Interest
        Route::get('/interest', [AlumniController::class, 'showInterest'])->name('kategori.interest');
        Route::get('/interest/{kodeInterest}', [AlumniController::class, 'showAlumniByInterest'])->name('kategori.interest.alumni');

        // Domisili
        Route::get('/domisili', [AlumniController::class, 'showDomisili'])->name('kategori.domisili');
        Route::get('/domisili/{kodeDomisili}', [AlumniController::class, 'showAlumniByDomisili'])->name('kategori.domisili.alumni');

        // Jurusan
        Route::get('/jurusan', [AlumniController::class, 'showJurusan'])->name('kategori.jurusan');
        Route::get('/jurusan/{kodeJurusan}', [AlumniController::class, 'showAlumniByJurusan'])->name('kategori.jurusan.alumni');

        // Pekerjaan
        Route::get('/pekerjaan', [AlumniController::class, 'showPekerjaan'])->name('kategori.pekerjaan');
        Route::get('/pekerjaan/{kodePekerjaan}', [AlumniController::class, 'showAlumniByPekerjaan'])->name('kategori.pekerjaan.alumni');
    });



// Redirect ke home jika mengakses root URL
// Route::get('/', function () {
//     return redirect()->route('alumni');
// })->middleware('auth');

// Route::view('/home', 'home');

});

Route::middleware('auth')->group(function() {
    Route::prefix('setup')->group(function () {
        //Otp
        Route::get('/whatsapp', [SetupController::class, 'formWhatsapp'])->name('setup.otp.whatsapp');
        Route::post('/request-otp', [SetupController::class, 'requestOtp'])->name('setup.otp.request');
        Route::post('/change-number', [SetupController::class, 'changeNumber'])->name('setup.otp.change');
        Route::post('/resend-otp', [SetupController::class, 'resendOtp'])->name('setup.otp.resend');
        Route::match(['get', 'post'], '/verify-otp/{token}', [SetupController::class, 'formOtp'])->name('setup.otp.form');
        Route::post('/verify-otp', [SetupController::class, 'verifyOtp'])->name('setup.otp.verify');

        //Password
        Route::get('/change-password', [SetupController::class, 'showChangePasswordForm'])->name('setup.password.form');
        Route::post('/change-password', [SetupController::class, 'changePassword'])->name('setup.password.save');
    });

});