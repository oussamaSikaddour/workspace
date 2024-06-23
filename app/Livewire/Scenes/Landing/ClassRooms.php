<?php

namespace App\Livewire\Scenes\Landing;

use App\Models\Classroom;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ClassRooms extends Component
{

    protected function getPrimaryImageUrl($classroom)
    {

        $primaryImage = $classroom->images->firstWhere('use_case', 'classroom_primary')
                      ?? $classroom->images->firstWhere('use_case', 'classroom');

        if ($primaryImage) {
            $this->dispatch('set-thumbnail-active', $primaryImage->id);
            return $primaryImage->url ?? "";
        }

        return "";
    }

        #[Computed()]
    public function ourClassrooms(){
        return Classroom::with('images')->where("status", "1")->get();

        }
    public function render()
    {
        return view('livewire.scenes.landing.class-rooms');
    }
}
