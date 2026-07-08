<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Track extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Disabilitiamo la protezione mass-assignment per velocizzare lo sviluppo.
     */
    protected $guarded = [];

    /**
     * Ottieni l'utente che ha caricato la traccia.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Ottieni l'artista collegato alla traccia.
     */
    public function artist()
    {
        return $this->belongsTo(\App\Models\Artist::class);
    }

    public function contests(): BelongsToMany
    {
        return $this->belongsToMany(Contest::class)
                    ->withPivot('accepted_legal_terms', 'accepted_at', 'status')
                    ->withTimestamps();
    }

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'playlist_track');
    }
}
