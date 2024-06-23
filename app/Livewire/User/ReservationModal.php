<?php

namespace App\Livewire\User;

use App\Livewire\Forms\Reservation\ManageForm;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReservationModal extends Component
{


    public ManageForm $form;
    public $minEndDate="";
    public $minStartDate="";
    public $classroomId="";

    public function updated($property){

        if($property ==="form.start_date"){
            $this->minEndDate=
            Carbon::parse($this->form->start_date)->toDateString();
            $this->form->end_date= $this->minEndDate;
         }
        }



        public function handleSubmit()
        {
            $this->dispatch('form-submitted');
            $response = $this->form->save();
            $this->form->reset('start_date','end_date',"start_time","close_time","reservation_days","capacity");
              session()->forget('capacity');
              session()->forget('dateStart');
             session()->forget('dateEnd');
              session()->forget('openTime');
             session()->forget('closeTime');
              session()->forget('workingDays');
            if ($response['status']) {
                $this->dispatch('update-days-off-table');
                $this->dispatch('open-toast', $response['message']);
            } else {
                $this->dispatch('open-errors', $response['errors']);
            }
        }

    public function mount(){
        session()->forget('currentClassRoomId');
        if(!Auth()->user()){
            session()->put("currentClassRoomId", $this->classroomId);
            $this->redirectRoute('loginPage');
        }
        $this->minStartDate = Carbon::tomorrow()->toDateString();
        $this->form->fill([
            'classroom_id'=>$this->classroomId,
           'capacity' => session()->get('capacity', ''),
          'start_date' => session()->get('dateStart', ''),
            'end_date' => session()->get('dateEnd', ''),
            'start_time' => session()->get('openTime', ''),
           'end_time' => session()->get('closeTime', ''),
          'reservation_days'=> session()->get('workingDays', [])
        ]);
    }
    public function render()
    {
        return view('livewire.user.reservation-modal');
    }
}
