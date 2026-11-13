<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active && in_array($this->role, ['super_admin', 'editor', 'curator']);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role',
        'is_active',
        'assigned_category_id',
        'real_name',
        'tax_code',
        'accepted_terms',
        'plan',
        'plan_expires_at',
        'supporter_badge',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'plan' => 'free',
        'supporter_badge' => false,
        'role' => 'artist',
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_active' => 'boolean',
            'plan_expires_at' => 'datetime',
            'supporter_badge' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if (in_array($user->role, ['editor', 'listener'])) {
                return;
            }

            $slug = Str::slug($user->name);

            // Evitiamo duplicati durante la registrazione
            if (Artist::where('slug', $slug)->exists()) {
                $slug = $slug . '-' . strtolower(Str::random(4));
            }

            $user->artist()->create([
                'name'  => $user->name,
                'slug'  => $slug,
                'style' => 'default',
            ]);
        });

        static::updated(function ($user) {
            if (in_array($user->role, ['editor', 'listener'])) {
                if ($user->artist) {
                    $user->artist()->delete();
                }
            } else {
                if (!$user->artist && in_array($user->role, ['artist', 'curator'])) {
                    $slug = Str::slug($user->name);
                    if (Artist::where('slug', $slug)->exists()) {
                        $slug = $slug . '-' . strtolower(Str::random(4));
                    }
                    $user->artist()->create([
                        'name'  => $user->name,
                        'slug'  => $slug,
                        'style' => 'default',
                    ]);
                }
            }
        });
    }

    public function artist(): HasOne
    {
        return $this->hasOne(Artist::class);
    }

    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    public function isCurator(): bool
    {
        return $this->role === 'curator';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }
}
