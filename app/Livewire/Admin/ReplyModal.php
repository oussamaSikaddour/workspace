<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Reply\AddForm;
use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Component;

class ReplyModal extends Component
{

    public  $message =[];
    public AddForm $form;
    public $messageContent="";




    #[On('set-message-content')]
    public function setDescriptionFr($content)
    {
        $this->form->fill([
            'message'=>$content
        ]);

    }


        public function handleSubmit()
        {
            $this->dispatch('form-submitted');
            $response = $this->form->save();
            $this->form->reset('message');
            if ($response['status']) {
                $this->dispatch('open-toast', $response['message']);
            } else {
                $this->dispatch('open-errors', $response['errors']);
            }
        }

    public function mount(){

        $this->dispatch('initialize-tiny-mce');
        $this->form->fill([
            'name'=>$this->message['name'],
            'email'=>$this->message['email'],
        ]);
    }
    public function render()
    {
        return view('livewire.admin.reply-modal');
    }
}
