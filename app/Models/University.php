<?php

namespace App\Models;

use App\Enums\UnivType;
use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'logo',
        'is_featured',
        'univ_type',
    ];

    protected $casts = [
        UnivType::class,
    ];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    public function alumnis(): HasMany
    {
        return $this->hasMany(UniversityAlumni::class, 'university_id', 'id');
    }


}
