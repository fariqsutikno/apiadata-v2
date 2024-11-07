<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alumni extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alumni_code',
        'full_name',
        'alias',
        'birth_place',
        'birth_date',
        'nik',
        'nism',
        'nisn',
        'passport_number',
        'is_life',
        'account_status',
        'marital_status',
        'ma_average',
        'im_average',
        'whatsapp',
        'emergency_contact',
        'email',
        'linkedin',
        'photo_link',
        'drive_link',
        'address',
        'predicate',
        'gen_id',
        'country_id',
        'province_id',
        'regency_id',
        'district_id',
        'village_id',
        'father_name',
        'father_status',
        'mother_name',
        'mother_status',
        'actived_at',
    ];

    public function gen(): BelongsTo
    {
        return $this->belongsTo(Gen::class);
    }

    public function organizationAlumnis(): HasMany
    {
        return $this->hasMany(OrganizationAlumni::class, 'alumni_id');
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'class_alumni', 'alumni_id', 'class_id');
    }

    public function classAlumnis(): HasMany
    {
        return $this->hasMany(ClassAlumni::class, 'alumni_id');
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'interest_alumni');
    }

    public function interestAlumnis(): HasMany
    {
        return $this->hasMany(InterestAlumni::class, 'alumni_id');
    }

    public function occupations(): HasMany
    {
        return $this->hasMany(Occupation::class);
    }

    public function universityAlumnis(): HasMany
    {
        return $this->hasMany(UniversityAlumni::class, 'alumni_id');
    }

    public function survey(): HasOne
    {
        return $this->hasOne(Survey::class);
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
