<?php

namespace App\Livewire;

use App\Models\Track;
use Livewire\Component;

class Player extends Component
{
    public $tracks;
    public $currentTrack;

    protected $listeners = ['playTrack' => 'playTrack'];

    public function mount()
    {
        $this->tracks = Track::active()->where('is_featured', true)->with('artist')->get();
        $this->currentTrack = $this->tracks->first();
    }

    public function playTrack($trackId)
    {
        $track = Track::with('artist')->find($trackId);
        if ($track) {
            $this->currentTrack = $track;
        }
    }

    public function render()
    {
        return view('livewire.player');
    }
}
