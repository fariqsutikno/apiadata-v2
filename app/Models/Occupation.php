<?php

namespace App\Models;

use App\Enums\JobCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Occupation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'job_title',
        'company_name',
        'company_field',
        'job_category',
        'start',
        'end',
        'is_khidmah',
        'alumni_id',
    ];

    protected $casts = [
        JobCategory::class,
    ];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class);
    }

    public function companyFields(){
        return $this->belongsTo(CompanyField::class, 'company_field');
    }
}
