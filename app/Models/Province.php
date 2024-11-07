<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class);
    }

    public function alumnis(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
