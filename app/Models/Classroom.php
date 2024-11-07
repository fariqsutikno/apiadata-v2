<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'class', 
        'year', 
        'teacher',
    ];

    public function getTitleAttribute()
    {
        return $this->class . ' - ' . $this->year;
    }
    
    public function alumnis(): BelongsToMany
    {
        return $this->belongsToMany(Alumni::class, 'class_alumni', 'class_id', 'alumni_id');
    }

    public function gen(): BelongsTo
    {
        return $this->belongsTo(Gen::class);
    }
}
