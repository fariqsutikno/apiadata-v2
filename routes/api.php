<?php

use App\Http\Controllers\Api\V1\StudiController;
use App\Http\Controllers\Api\V1\VillagesController;
use App\Models\Village;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Route::prefix('v1')->group(function(){
    Route::get('/desa', [VillagesController::class, 'index'])->name('api.villages.index');
    Route::get('/desa/search', [VillagesController::class, 'search'])->name('api.villages.search');

    Route::get('/studi/get-university', [StudiController::class, 'getUniversity'])->name('api.studi.getuniversity');
    Route::get('/studi/get-program', [StudiController::class, 'getProgram'])->name('api.studi.getprogram');
});