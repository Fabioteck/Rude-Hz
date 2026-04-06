<?php

namespace App\Livewire;

use App\Models\Track;
use Livewire\Component;

class Player extends Component
{
    public $tracks;
    public $currentTrack;

    public function mount()
    {
        $this->tracks = Track::where('is_featured', true)->with('artist')->get();
        $this->currentTrack = $this->tracks->first();
    }

    public function render()
    {
        return view('livewire.player');
    }
}
