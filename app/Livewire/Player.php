<?php

namespace App\Livewire;

use App\Models\Track;
use App\Services\ImageOptimizerService;
use Livewire\Component;

class Player extends Component
{
    public $tracksQueue = [];

    public function mount()
    {
        $this->loadQueue();
    }

    public function loadQueue()
    {
        $tracks = Track::active()->where('is_featured', true)->with('artist')->get();
        if ($tracks->isEmpty()) {
            $tracks = Track::active()->with('artist')->get();
        }
        
        $this->tracksQueue = $tracks->map(function($t) {
            return [
                'id' => $t->id,
                'title' => $t->title,
                'artist' => $t->artist->name ?? 'Unknown Artist',
                'audio_url' => asset('storage/' . $t->file_path),
                'cover_url' => $t->cover_path ? asset('storage/' . $t->cover_path) : ImageOptimizerService::placeholderUrl(),
            ];
        })->values()->toArray();
    }

    public function render()
    {
        return view('livewire.player', [
            'tracksQueue' => $this->tracksQueue,
        ]);
    }
}
