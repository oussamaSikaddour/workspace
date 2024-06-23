<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductShow extends Component
{

  public $productId = "";
  public $product = null;
  public $primaryImgUrl = "";
  public $name = "";
  public $description = "";


  public function goBack() {
    $previousUrl = session()->get('previousUrl');
    if ($previousUrl) {
      session()->forget('previousUrl'); // Optional: Clear session after use
      return redirect()->to($previousUrl);
    } else {
      // Handle case where no previous URL exists (e.g., redirect to homepage)
      return redirect()->to('/');
    }
  }

  public function setPrimaryImage($imageId)
{

    $this->dispatch('set-thumbnail-active',$imageId);
    if (!auth()->user() || !auth()->user()->can("admin-access")) {
      return;  // Access denied for non-admin users
    }
  // Update all images to 'product' use_case
  $this->product->images->each(function ($image) {
    $image->use_case = 'product';
    $image->save();
  });

  // Update clicked image to 'product_primary' use_case
  $clickedImage = $this->product->images->find($imageId);
  $clickedImage->use_case = 'product_primary';
  $clickedImage->save();

  $this->primaryImgUrl = $clickedImage->url;
}
protected function getPrimaryImageUrl()
{
    if (!$this->product) {
        return "";
    }

    $primaryImage = $this->product->images->firstWhere('use_case', 'product_primary')
                  ?? $this->product->images->firstWhere('use_case', 'product');

    if ($primaryImage) {
        $this->dispatch('set-thumbnail-active', $primaryImage->id);
        return $primaryImage->url ?? "";
    }

    return "";
}



  public function mount()
  {
    session()->put('previousUrl', url()->previous());
    $this->product = Product::with('images')->where('id', $this->productId)->first();
    $this->primaryImgUrl = $this->getPrimaryImageUrl();

    $this->name = app()->getLocale() === 'ar' ? $this->product->name_ar : $this->product->name_fr;
    $this->description = app()->getLocale() === 'ar' ? $this->product->description_ar : $this->product->description_fr;
  }

  public function render()
  {
    return view('livewire.product-show');
  }
}
