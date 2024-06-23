<?php

namespace App\Livewire\Admin;

use App\Models\Message;
use App\Traits\TableTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MessagesTable extends Component
{


    use WithPagination, TableTrait;
#[Url()]
public $name ="";
#[Url()]
public $email = "";




public function resetFilters(){
$this->name="";
$this->email="";
}






#[Computed()]
public function messages()
{
    $query = Message::query();
        $query->where('email', 'like', "%{$this->email}%");
        $query->where('name', 'like', "%{$this->name}%"); // Specify table name
        $query->orderBy($this->sortBy, $this->sortDirection);
    return $query->paginate($this->perPage);
}




public function updated($property){


    if(in_array($property,['name','email','perPage','sortBy','sortDirection'])){

        $this->resetPage();
    }
}









#[On("delete-message")]
public function deleteMessage(Message $msg){
    $msg->delete();
}





    public function render()
    {
        return view('livewire.admin.messages-table');
    }
}
