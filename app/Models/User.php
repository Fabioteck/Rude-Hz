<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * I campi che possono essere scritti nel database.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * I campi da nascondere nelle risposte JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast degli attributi (password hashata e date).
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function artist()
    {
        return $this->hasOne(Artist::class);
    }

}
