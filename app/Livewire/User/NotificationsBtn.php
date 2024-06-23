<?php

namespace App\Livewire\User;

use App\Models\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;

class NotificationsBtn extends Component
{


    public $notificationsCount=0;


    public function refreshNotifications()
    {
       $this->dispatch('refresh-notifications');
    }


    #[Computed()]
    public function notifications(){
        if(auth()->user()->can("admin-access")){
           $query= Notification::where('active',true)->where('targetable_type','admin');
        }else{
               $query = Notification::where('targetable_id', auth()->user()->id)
                ->where('active',true);
        }
        return $query->orderBy('created_at', 'desc')->get();
    }


    public function mount(){
        $this->notificationsCount = count($this->notifications);
    }
    public function manageNotification(Notification $notification){

        $notification->active=false;
        $notification->update();

        if($notification->for_type="reservation"){
        $this->redirectRoute('home');
         }
         if($notification->for_type="message"){
            $this->redirectRoute('messages');
         }

    }
    public function render()
    {
        return view('livewire.user.notifications-btn');
    }
}
