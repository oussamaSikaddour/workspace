<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\DaysOff\AddForm;
use App\Livewire\Forms\DaysOff\UpdateForm;
use App\Models\DayOff;
use Illuminate\Support\Carbon;
use Livewire\Component;

class DaysOffModal extends Component
{

    public AddForm $form;
    public DayOff $daysOff;
    public $classroomId="";
    public $minDateEnd="";
    public $minDateStart="";





    public function updated($property){

        if($property ==="form.days_off_start"){
       $this->minDateEnd=
       Carbon::parse($this->form->days_off_start)->addDays(1)->toDateString();

       $this->form->days_off_end= $this->minDateEnd;
        }
     }


    public function mount()
    {
        $this->minDateStart = Carbon::tomorrow()->toDateString();
        $this->form->fill([
                'classroom_id' => $this->classroomId,
            ]);
    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response = $this->form->save();
        $this->form->reset('days-off-start','days-off-end');
        if ($response['status']) {
            $this->dispatch('update-days-off-table');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    public function render()
    {
        return view('livewire.admin.days-off-modal');
    }
}
