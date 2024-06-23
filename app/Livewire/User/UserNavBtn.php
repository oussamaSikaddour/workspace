<?php

namespace App\Livewire\User;

use App\Models\Image;
use Livewire\Component;

class UserNavBtn extends Component
{
     public $userProfilePicUrl=null;
     public $userName= "";

    public function mount(){
         $user = auth()->user();
        $this->userName =  $user->name;
        $profilePic = Image::where('imageable_id', $user->id)
        ->where('imageable_type','App\Models\User')
        ->where('use_case','profile_pic')
        ->first();
if ($profilePic) {
    $this->userProfilePicUrl = $profilePic->url; // Access the image path
} else {
    // Handle the case where there's no profile picture
    $this->userProfilePicUrl = asset("img/default.png"); // Or provide a default placeholder image path
}

    }
    public function render()
    {
        return view('livewire.user.user-nav-btn');
    }
}
