<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\Reservation;
use App\Traits\GeneralTrait;
use App\Traits\TableTrait;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;
class ReservationsTable extends Component
{

    use WithPagination, TableTrait,GeneralTrait;

    #[Url()]
    public $dateStart= "";
    #[Url()]
    public $dateEnd= "";
    public $minDateEnd="";
    public $minDateStart="";
    #[Url()]
    public $client="";
    #[Url()]
    public $classroom="";
    public $showForAdmin=false;




    public function resetFilters(){
        $this->dateStart="";
        $this->dateEnd="";
        $this->client="";
        $this->classroom="";

        }



        public function updated($property){

            if($property ==="dateStart"){
                $this->minDateEnd=
                Carbon::parse($this->dateStart)->addDays(1)->toDateString();
                $this->dateEnd= $this->minDateEnd;
             }
            if(in_array($property,['perPage','sortBy','sortDirection','client','classroom','dateStart',"dateEnd"])){
                $this->resetPage();
            }
        }


        #[On("selected-value-updated")]
        public function changeStateForReservation(Reservation $entity, $value){
            try {


             $entity->state = $value;
             $entity->save();
             if($value ==="valid"){
                $notification = new Notification();
                $notification->for_type="reservation";
                $notification->message = 'validate'; // Customize message
                $notification->targetable_id = $entity->user->id;
                $notification->save();

             }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [$e->getMessage()]);
        }
        }

        #[Computed()]
 public function reservations()
        {
            $query = Reservation::query()
                ->with(['user', 'classroom'])
                ->leftJoin('classrooms', 'reservations.classroom_id', '=', 'classrooms.id')
                ->leftJoin('users', 'reservations.user_id', '=', 'users.id')
                ->leftJoin('personnel_infos', 'users.id', '=', 'personnel_infos.user_id');

            if ($this->showForAdmin) {
                if ($this->client !== "") {
                    $query->whereHas('user', function ($query) {
                        $query->where('last_name', 'LIKE', '%' . $this->client . '%')
                            ->orWhere('first_name', 'LIKE', '%' . $this->client . '%');
                    });
                }
            } else {
                $query->whereHas('user', function ($query) {
                    $query->where('id', auth()->user()->id);
                });
            }

            if ($this->classroom !== "") {
                $locale = app()->getLocale();
                $nameField = $locale === 'ar' ? 'name_ar' : 'name_fr' ;
                $query->where($nameField, 'like', "%{$this->classroom}%");
            }

            if ($this->dateStart !== "" && $this->dateEnd !== "") {
                $query->where(function ($query) {
                    $query->whereBetween('start_date', [$this->dateStart, $this->dateEnd])
                        ->orWhereBetween('end_date', [$this->dateStart, $this->dateEnd])
                        ->orWhere(function ($query) {
                            $query->where('start_date', '<', $this->dateStart)
                                ->where('end_date', '>', $this->dateEnd);
                        });
                });
            }

            $query->select('reservations.*', 'classrooms.name_ar', 'classrooms.name_fr');

            if ($this->showForAdmin) {
                $query->addSelect('users.name');
            }

            $query->orderBy($this->sortBy, $this->sortDirection);

            return $query->paginate($this->perPage);
        }







        public function generateReservationsExcel(){
            return $this->generateExcel(function() {
                return $this->reservations()->map(function ($r) {
                    $classroom = app()->getLocale() === 'ar' ? $r->name_ar : $r->name_fr;
                    return [
                        __("tables.reservations.client")=> $r->name,
                        __("tables.reservations.classroom") => $classroom,
                        __("tables.reservations.state") => app('my_constants')['RESERVATION_STATE'][app()->getLocale()][$r->state],
                        __('modals.reservation.startDate') =>$r->start_date,
                        __('modals.reservation.endDate') =>$r->end_date,
                        __('modals.reservation.startTime') =>app('my_constants')['HOURS'][$r->start_Time]??"",
                        __('modals.reservation.endTime') =>app('my_constants')['HOURS'][$r->end_Time]??"",
                        __('tables.reservations.totalPrice') =>$r->total_price,
                    ];
                })->toArray();
            }, "reservations");
        }



        #[On("delete-reservation")]
        public function deleteUser(Reservation $reservation){
            try{
             $reservation->delete();
             } catch (\Exception $e) {
             $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }

public function printConfirmationPdf($reservationData)
{
   try {
    $classroomName = app()->getLocale() === 'ar' ? $reservationData['classroom']['name_ar']:$reservationData['classroom']['name_fr'];


         $reservationData["classroom_name"]= $classroomName;

         $reservationData["start_date"]=$this->parseDate($reservationData['start_date']);
         $reservationData["end_date"]=$this->parseDate($reservationData['end_date']);
        $pdf = PDF::loadView("pdfs." . app()->getLocale() . ".reservation", compact('reservationData'));
        $tempDir = storage_path('app/temp/');
        $tempFilePath = $tempDir . 'reservation.pdf';
        $pdf->save($tempFilePath);
        return response()->download($tempFilePath, 'rendezvous.pdf')
            ->deleteFileAfterSend(true);
    } catch (\Exception $e) {
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
}


    public function mount()
    {
    $this->minDateStart = Carbon::today()->toDateString();
      if(auth()->user()->can("admin-access")){
        $this->showForAdmin=true;
        }

    }


    public function render()
    {
        return view('livewire.reservations-table');
    }
}
