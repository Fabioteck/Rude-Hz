<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contest extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'legal_disclaimer', 
        'image_path', 'rules_pdf', 'playlist_url', 
        'max_tracks_per_artist', 'start_date', 'end_date', 'is_active'
    ];

    // Relazione con le tracce partecipanti
    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class)
                    ->withPivot('accepted_legal_terms', 'accepted_at', 'status')
                    ->withTimestamps();
    }
}
