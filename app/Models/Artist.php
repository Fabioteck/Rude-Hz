<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importa questa!

class Artist extends Model
{
    protected $guarded = [];

    /**
     * Relazione: L'artista appartiene a un utente registrato.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione: Un artista può avere molte tracce.
     */
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }
}
