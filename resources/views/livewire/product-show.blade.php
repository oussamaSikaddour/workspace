
  <main class="showcase" wire:ignore>
    <div class="showcase__head">
        <button class="button rounded button--primary" wire:click="goBack()">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h1>{{ $name }}</h1>
    </div>

    <div class="showcase__body">
    <div class="showcase__imgs__container">

      <div class="showcase__img__primary">
        <img src="{{ $primaryImgUrl }}" alt="product">
      </div>

      <div class="showcase__imgs" >

        @foreach ($product->images as $image )
        <div class="showcase__img"  wire:click="setPrimaryImage({{ $image->id }})">
            <img src="{{ $image->url }}" alt="product" id="{{ $image->id }}-p-img">
          </div>
        @endforeach

      </div>
    </div>


  <div class="showcase__content">
    <div class="showcase__header">

    </div>
    <div class="showcase__infos">
      <div class="showcase__info">
        <h2>@lang('pages.product.product.quantity')</h2>
        <ul>
          <li>{{ $product->quantity }}</li>
        </ul>

      </div>
      <div class="showcase__info">
        <h2>@lang('pages.product.product.price')</h2>
      <ul>
        <li> <p>{{ $product->price }}</p>
          <p>@lang('pages.product.product.currency')</p></li>
      </ul>
      </div>
      </div>

    <div class="showcase__description">
{!!  $description !!}
    </div>



  </div>

</div>


  </main>




