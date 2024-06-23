<section class="products" id="products">

    @if (  count($this->ourProducts()) >0 )



    <div class="products__header">
        <h1>
            @lang("pages.landing.links.products")
        </h1>
        <a href="{{ route("productsPages") }}">@lang('nav.see-all')</a>

      </div>
    <div class="scroller__container">

        <button class=" rounded scroller__btn scroller__btn--left">
            <i class="fa-solid fa-angle-left"></i>
          </button>
          <button class="rounded scroller__btn scroller__btn--right">
            <i class="fa-solid fa-angle-right"></i>
        </button>
     <div class="scroller ">
      <div class="scroller__inner">

        @foreach ( $this->ourProducts() as $p )
     @php
    $primaryImgUrl = $this->getPrimaryImageUrl($p);

$name = app()->getLocale() === 'ar' ? $p->name_ar : $p->name_fr;
$description = app()->getLocale() === 'ar' ? $p->description_ar : $p->description_fr;
     @endphp

        <div class="product">
            <h1 class="product__brand">{{ $name }}</h1>
            <div class="product__cover">

              <img  src="{{ $primaryImgUrl }}" alt="{{ $name }}" />
            </div>
            <div class="product__content">
              <h3>{{ $name }}</h3>
              <h2 class="product__heading">@lang('pages.product.product.currency')
            {{ $p->price }}</h2>
              <a    href="{{ route('product',$p->id) }}"  class="button  rounded transparent">
              <span><i class="fa-regular fa-eye"></i></span>
             </a>
            </div>
            </div>


        @endforeach
    </div>
    </div>
    </div>

@endif
  </section>
