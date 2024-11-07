<?php

namespace App\Models;

use App\Enums\AdmissionPath;
use App\Enums\CompletionStatus;
use App\Enums\FundingSource;
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
        'completion_status',
        'admission_path',
        'funding_source',
        'is_accepted',
        'is_enrolled',
        'priority',
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
}
