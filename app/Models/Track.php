<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Track extends Model
{
    use HasFactory;

    /**
     * Disabilitiamo la protezione mass-assignment per velocizzare lo sviluppo.
     */
    protected $guarded = [];

    /**
     * Relazione: Ogni brano appartiene a un artista.
     * Fondamentale per Filament e per mostrare il nome dell'artista nel Player.
     */
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }
}
