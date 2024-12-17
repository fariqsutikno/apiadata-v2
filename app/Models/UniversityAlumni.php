<?php

namespace App\Models;

use App\Enums\AdmissionPath;
use App\Enums\CompletionStatus;
use App\Enums\FundingSource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UniversityAlumni extends Model
{
    use HasFactory;

    protected $table = 'university_alumni';
    
    protected $fillable = [
        'alumni_id',
        'university_id',
        'program_id',
        'start',
        'end',
        'month_start',
        'year_start',
        'month_end',
        'year_end',
        'completion_status',
        'admission_path',
        'funding_source',
        'is_accepted',
        'is_enrolled',
        'priority',
        'is_visible',
        'snbt_score'
    ];

    protected $casts = [
        'admission_path' => AdmissionPath::class,
        'completion_status' => CompletionStatus::class,
        'funding_source' => FundingSource::class,
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    // Accessor untuk mendapatkan nama bulan dari month_start
    public function getMonthStartNameAttribute()
    {
        if(!$this->month_start){
            return null;
        }

        // Set locale ke bahasa Indonesia
        Carbon::setLocale('id');

        // Mengonversi month_start menjadi nama bulan
        return Carbon::createFromFormat('!m', $this->month_start)->translatedFormat('F');
    }

    // Accessor untuk mendapatkan nama bulan dari month_end
    public function getMonthEndNameAttribute()
    {
        if(!$this->month_end){
            return null;
        }
        // Set locale ke bahasa Indonesia
        Carbon::setLocale('id');

        // Mengonversi month_end menjadi nama bulan
        return Carbon::createFromFormat('!m', $this->month_end)->translatedFormat('F');
    }

    public function getIsHiddenAttribute()
    {
        return !$this->is_visible;
    }
}
