

<div class="pages__container" >

<div class="pages__filters">
    <div class="row">
        <x-form.input
        name="name"
        :label="__('tables.products.name')"
        type="text"
        html_id="tName"
        role="filter"/>
        <x-form.input
        name="quantity"
        :label="__('modals.product.quantity')"
        type="text"
        html_id="tQuantity"
        role="filter"/>
        <x-form.input
        name="price"
        :label="__('modals.product.price')"
        type="text"
        html_id="tPrice"
        role="filter"/>
    </div>
    <div class="row center">
        <button
        class="button button--primary rounded  hasToolTip"
         wire:click="resetFilters">
         <span
         id="trashToolTip3"
         class="toolTip"
         role="tooltip"
         aria-label="resest Filters"
       >
       @lang("toolTips.common.resetFilters")
       </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
</div>
</div>

<div class="pages">


    @if (count($this->products) > 0)
    @foreach ( $this->products as $p )
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
  @endif

</div>
{{ $this->products->links('components.pagination') }}
  </div>
