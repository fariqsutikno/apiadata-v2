<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'univ_factor',
        'program_factor',
        'activity',
        'pia_impact',
        'kritik'
    ];

    protected $casts = [
        'univ_factor' => 'array',
        'program_factor' => 'array',
        'activity' => 'array',
        'pia_impact' => 'array',
    ];

    // protected static function boot()
    // {
    //     parent::boot();
    
    //     static::creating(function ($model) {
    //         $model->user_id = auth()->id();
    //     });
    // }
}
