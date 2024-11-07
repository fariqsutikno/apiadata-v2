<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gen extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'year',
        'leader',
    ];

    public function alumnis(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
