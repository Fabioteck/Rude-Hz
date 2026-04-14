<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // AGGIUNTO: permette il salvataggio del ruolo
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // FONDAMENTALE: forza Laravel a vederlo come true/false
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
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
    }

    public function artist(): HasOne
    {
        return $this->hasOne(Artist::class);
    }
}
