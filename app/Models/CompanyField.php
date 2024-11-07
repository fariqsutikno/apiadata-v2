<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyField extends Model
{
    use HasFactory;

    protected $fillable = [
        'field'
    ];

    public $timestamps = false;

    public function occupations(): HasMany
    {
        return $this->hasMany(Occupation::class, 'company_field');
    }
}
