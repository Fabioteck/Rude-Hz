<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Artist extends Model
{
    /**
     * Permette il mass-assignment su tutti i campi.
     */
    protected $guarded = [];

    /**
     * Boot logic per la gestione dello slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artist) {
            // Genera lo slug solo se non è già stato impostato (es. nel Controller)
            if (!$artist->slug && $artist->name) {
                $artist->slug = Str::slug($artist->name);
            }
        });

        static::updating(function ($artist) {
            // Opzionale: aggiorna lo slug se il nome cambia (attenzione ai link rotti!)
            // Se preferisci slug immutabili, commenta queste righe
            if ($artist->isDirty('name') && !$artist->isDirty('slug')) {
                $artist->slug = Str::slug($artist->name);
            }
        });
    }

    /**
     * IMPORTANTE: NON aggiungere getRouteKeyName() qui. 
     * La gestione dello slug è fatta direttamente nel file web.php 
     * tramite il binding esplicito {artist:slug}.
     */

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
