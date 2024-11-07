<?php

namespace App\Models;

use App\Enums\Degree;
use App\Enums\ProgramType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_id',
        'name',
        'degree',
        'program_type',
        'category_id',
        'country_id',
        'province_id',
        'regency_id',
    ];

    protected $casts = [
        'degree' => Degree::class,
        'program_type' => ProgramType::class,
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function alumnis(): HasMany
    {
        return $this->hasMany(UniversityAlumni::class, 'program_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProgramCategory::class, 'category_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
