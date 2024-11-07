<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationAlumni extends Model
{
    use HasFactory;

    protected $table = 'organization_alumni';

    protected $fillable = [
        'organization_id', 
        'alumni_id', 
        'start',
        'year',
        'end', 
        'position'
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
