<?php

namespace App\Livewire\Scenes\Landing;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Products extends Component
{

    protected function getPrimaryImageUrl($product)
{

    $primaryImage = $product->images->firstWhere('use_case', 'product_primary')
                  ?? $product->images->firstWhere('use_case', 'product');

    if ($primaryImage) {
        $this->dispatch('set-thumbnail-active', $primaryImage->id);
        return $primaryImage->url ?? "";
    }

    return "";
}

    #[Computed()]
public function ourProducts(){
    return Product::with('images')->where("status", "1")->get();

    }
    public function render()
    {
        return view('livewire.scenes.landing.products');
    }
}
