<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_code_alpha3',
        'country_code_numeric',
    ];

    public function alumnis(): HasMany
    {
        return $this->hasMany(Alumni::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
