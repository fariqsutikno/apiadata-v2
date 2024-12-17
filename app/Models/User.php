<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use BezhanSalleh\FilamentShield\Support\Utils;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasRoles, HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'nism',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function alumni():BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'nism', 'nism');
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_alumni', 'alumni_id', 'class_id');
    }

    protected static function booted(): void
    {
        if(config('filament-shield.alumni_user.enabled', false)){
            FilamentShield::createRole(config('filament-shield.alumni_user.name', 'alumni_user'));

            static::created(fn ($user) => $user->assignRole(config('filament-shield.alumni_user.name', 'alumni_user')));

            static::deleting(fn ($user) => $user->removeRole(config('filament-shield.alumni_user.name', 'alumni_user')));
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if($panel->getId() === 'admin'){
            return $this->hasRole(Utils::getSuperAdminName());

        } elseif($panel->getId() === 'alumni'){
            return $this->hasRole(config('filament-shield.alumni_user.name', 'alumni_user'));

        } else {
            return false;
        }
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if (strpos($this->avatar_url, 'http') === 0 || strpos($this->avatar_url, 'https') === 0) {
            return $this->avatar_url;
        } else {
            return $this->avatar_url ? Storage::url("$this->avatar_url") : null;
        }
    }


}
