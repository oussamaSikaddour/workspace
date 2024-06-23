

<div class="pages__container" >

<div class="pages__filters">
    <div class="row center">
        <x-form.input
        name="name"
        :label="__('tables.trainings.name')"
        type="text"
        html_id="tName"
        role="filter"/>
        <x-form.input
        name="capacity"
        :label="__('modals.training.capacity')"
        type="number"
        html_id="tCapcity"
        role="filter"/>
    </div>
    <div class="row center">
        <x-form.input
        name="pricePerSession"
        :label="__('modals.training.pricePerSession')"
        type="number"
        html_id="tPricePS"
        role="filter"/>
        <x-form.input
        name="totalPrice"
        :label="__('modals.training.priceTotal')"
        type="number"
        html_id="tTprice"
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


    @if (count($this->trainings) > 0)
    @foreach ($this->trainings as $tr )
    @php
        $name = app()->getLocale() === 'ar' ? $tr->name_ar : $tr->name_fr;
    @endphp

          <div class="card">
            <div class="card__cover">
              <img src="{{ $tr->image->url }}" alt="{{ $name }}" />
            </div>
            <div class="card__content">

                <h2>{{ $name }}</h2>
                 <div class="card__actions">
                    <a  href="{{ route('training',$tr->id) }}" class="button  rounded transparent">
                     <span><i class="fa-regular fa-eye"></i></span>
                    </a>
                 </div>

            </div>

          </div>
          @endforeach
  @endif

</div>
{{ $this->trainings->links('components.pagination') }}
  </div>
