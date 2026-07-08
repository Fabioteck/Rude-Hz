<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'cover_path'];

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'playlist_track')
                    ->with('artist'); // Eager loading artist by default
    }
}
