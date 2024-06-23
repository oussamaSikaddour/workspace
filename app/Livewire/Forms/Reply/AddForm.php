<?php

namespace App\Livewire\Forms\Reply;

use App\Events\Auth\ReplyEvent;
use App\Traits\ResponseTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait ;

    public $name;
    public $message;
    public $email;






    public function rules()
    {


        return [
            "message"=>'required|string|min:10'
        ];

    }



 public function validationAttributes()
 {
     return [
         'message' => __('forms.message.message'),
     ];
 }


 public function save()
 {
    $validatedData = $this->validate();
     try {

         $validatedData["name"]=$this->name;
         $validatedData["email"]=$this->email;
        event(new ReplyEvent($validatedData));
        return $this->response(true,message:__('modals.reply.success'));
     } catch (\Exception $e) {
         return $this->response(false, errors: [$e->getMessage()]);
     }
 }
}
