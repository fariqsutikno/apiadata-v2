<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassAlumni extends Pivot
{
    use HasFactory;

    protected $table = "class_alumni";

    protected $fillable = [
        'alumni_id',
        'class_id'
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
