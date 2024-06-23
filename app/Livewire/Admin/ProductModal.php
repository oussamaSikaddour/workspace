<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\Product\AddForm;
use App\Livewire\Forms\Product\UpdateForm;
use App\Models\Image;
use App\Models\Product;
use App\Traits\GeneralTrait;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ProductModal extends Component
{

    use WithFileUploads,GeneralTrait;
    public AddForm $addForm;
    public UpdateForm $updateForm;
    public Product $product;
    public $descriptionFr="";
    public $descriptionAr="";
    public $id = "";
    public $temporaryImageUrls=[];




    public function updated($property)
    {
        try {

            if ($property === "addForm.images" && $this->addForm->images) {
                $this->temporaryImageUrls=[];
                foreach ($this->addForm->images as $image) {
                    if (!$image->temporaryUrl()) {
                        $this->temporaryImageUrls = []; // Set to empty array if any image doesn't have a temporary URL
                        break; // Exit the loop
                    }
                    $this->temporaryImageUrls[] = $image->temporaryUrl();
                }
            }

            if ($property === "updateForm.images" && $this->updateForm->images) {

                $this->temporaryImageUrls= [];
                foreach ($this->updateForm->images as $image) {
                    if (!$image->temporaryUrl()) {
                        $this->temporaryImageUrls = []; // Set to empty array if any image doesn't have a temporary URL
                        break; // Exit the loop
                    }
                    $this->temporaryImageUrls[] = $image->temporaryUrl();
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('open-errors', [__('modals.product.img-err')]);
        }
    }


    public function mount()
    {

        $this->dispatch('initialize-tiny-mce');
        if ($this->id !== "") {
            try {
              $this->product = product::findOrFail($this->id);
               $this->descriptionAr=$this->product->description_ar;
               $this->descriptionFr=$this->product->description_fr;
              $images = Image::where('imageable_id', $this->id)
              ->where('imageable_type','App\Models\Product')
              ->where('use_case','product')->get();
              foreach($images as $image){
               $this->temporaryImageUrls[] = $image?->url ?? "";
              }
                $this->updateForm->fill([
                    'id' => $this->id,
                    'name_fr'=>$this->product->name_fr,
                    'name_ar'=>$this->product->name_ar,
                    'description_fr'=>$this->product->description_fr,
                    'description_ar'=>$this->product->description_ar,
                    'price'=>$this->product->price,
                    'quantity'=>$this->product->quantity,

                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }
        }
    }


    public function handleSubmit()
    {
        $this->dispatch('form-submitted');

        $response = ($this->id !== "")
            ? $this->updateForm->save($this->product)
            : $this->addForm->save();

            if ($this->id === "") {
                $this->addForm->images=[];
                $this->temporaryImageUrls=[];
        }

        if ($response['status']) {
            $this->dispatch('update-products-table');
            $this->dispatch('open-toast', $response['message']);
            if ($this->id === "") {
                $this->addForm->reset();
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    #[On('set-description-fr')]
    public function setDescriptionFr($content)
    {
     if ($this->id !== "") {
        $this->updateForm->fill([
            'description_fr'=>$content
        ]);
     }else{
         $this->addForm->fill([
             'description_fr'=>$content
         ]);
     }
    }
    #[On('set-description-ar')]
    public function setDescriptionAr($content)
    {
     if ($this->id !== "") {
        $this->updateForm->fill([
            'description_ar'=>$content
        ]);
     }else{
         $this->addForm->fill([
             'description_ar'=>$content
         ]);
     }
    }
    public function render()
    {
        return view('livewire.admin.product-modal');
    }
}
