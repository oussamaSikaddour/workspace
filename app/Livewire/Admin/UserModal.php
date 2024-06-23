<?php
namespace App\Livewire\Admin;
use App\Livewire\Forms\User\UpdateForm;
use App\Livewire\Forms\User\AddForm;
use App\Models\Image;
use App\Models\User;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UserModal extends Component
{

    use WithFileUploads;
    public AddForm $addForm;
    public UpdateForm $updateForm;
    public User $user;
    public $id = "";
    public $temporaryImageUrl=null;
    public $currentTabIndex;


    public function setCurrentTabIndex($index){
        $this->currentTabIndex = $index;
    }




 public function updated($property){
    try{
    if($property ==="addForm.image" && $this->addForm->image){
        $this->dispatch("select-first-tab");
           $this->temporaryImageUrl = $this->addForm->image->temporaryUrl();

      }
    if($property ==="updateForm.image" && $this->updateForm->image){
        $this->dispatch("select-first-tab");
           $this->temporaryImageUrl = $this->updateForm->image->temporaryUrl();
      }
    }catch (\Exception $e) {
        $this->dispatch('open-errors', [__('modals.common.img-type-err',['attribute'=>__("modals.user.profile-img")])]);
    }
 }



    public function mount()
    {

     $this->temporaryImageUrl=asset('img/default.png');
        if ($this->id !== "") {
            try {
              $this->user = User::with('personnelInfo')->findOrFail($this->id);
               $profilePic = Image::where('imageable_id', $this->user->id)
               ->where('imageable_type','App\Models\User')
               ->where('use_case','profile_pic')
               ->first();
               $this->temporaryImageUrl = $profilePic?->url ?? $this->temporaryImageUrl;

                $this->updateForm->fill([
                    'default.id' => $this->id,
                    'personnelInfo.user_id' => $this->user->id,
                    'personnelInfo.last_name' => $this->user->personnelInfo?->last_name,
                    'personnelInfo.first_name' => $this->user->personnelInfo?->first_name,
                    'personnelInfo.birth_date' => $this->user->personnelInfo?->birth_date,
                    'personnelInfo.birth_place' => $this->user->personnelInfo?->birth_place,
                    'personnelInfo.address' => $this->user->personnelInfo?->address,
                    'personnelInfo.tel' => $this->user->personnelInfo?->tel,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }
    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        if(auth()->id()===$this->id){
           $this->dispatch("update-nav-user-btn");
        }
        $response = ($this->id !== "")
            ? $this->updateForm->save($this->user)
            : $this->addForm->save();
        if ($this->id === "") {
            $this->addForm->reset('personnelInfo','default');
        }
        if ($response['status']) {
            $this->dispatch('update-users-table');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    public function render()
    {
        $this->dispatch("user-model-rendered");
        return view('livewire.admin.user-modal');
    }
}
