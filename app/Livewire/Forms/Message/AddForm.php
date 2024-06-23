<?php

namespace App\Livewire\Forms\Message;

use App\Models\Message;
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
            'name' => 'required|string|min:3|max:200',
            'email'=>'required|string|email|max:255',
            "message"=>'required|string|min:10'
        ];

    }



 public function validationAttributes()
 {
     return [
         'name' => __('forms.message.name'),
         'email' => __('forms.message.email'),
         'message' => __('forms.message.message'),
     ];
 }


 public function save()
 {
    $validatedData = $this->validate();
     try {
        Message::create($validatedData);
        return $this->response(true,message:__("forms.message.add.success-txt"));
     } catch (\Exception $e) {
         return $this->response(false, errors: [$e->getMessage()]);
     }
 }


}
