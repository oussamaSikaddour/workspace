@php
    $HoursOptions = app('my_constants')['HOURS'];
    $days = app('my_constants')['WEEK_DAYS'][app()->getLocale()];
@endphp

<div class="pages__container" >

    <div class="pages__filters">

        <div class="row">
         <x-form.input
         name="dateStart"
        :label="__('modals.days-off.days-off-start')"
         type="date"
        html_id="cpfDS"
        role="filter"
        :min="$minDateStart"
         />
        <x-form.input
        name="dateEnd"
        :label="__('modals.days-off.days-off-end')"
         type="date"
        html_id="cpfDE"
        role="filter"
        :min="$minDateEnd"
        />
       </div>
       <div class="row">
        <x-form.input
        name="capacity"
        :label="__('modals.classroom.capacity')"
         type="number"
           role="filter"
        html_id="cpfCA"
        :min="1"
        />

            <x-form.selector htmlId="cpfRopenTime" name="openTime"
            :label="__('modals.classroom.openTime')" :data="$HoursOptions" type="filter" />
            <x-form.selector htmlId="cpfcloseTime" name="closeTime"
            :label="__('modals.classroom.closeTime')" :data="$HoursOptions" type="filter" />
      </div>
      <div class="row">
            <p>@lang('modals.classroom.workingDays') :</p>
            @if(isset($days) && count($days)>0)
                <div class="checkbox__group">
                    <h2 id="checkbox-choices" class="sr-only">@lang('modals.classroom.workingDays')</h2>
                    <div class="choices" day="groupe" aria-labelledby="checkbox-choices">
                        @foreach($days as $value => $key)
                            <x-form.check-box :live="true" model="workingDays" value="{{ $value }}" label="{{ $key }}" htmlId="cpf-{{ $value }}" />
                        @endforeach
                    </div>
                </div>
            @endif
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


    @if (count($this->classrooms) > 0)
    @foreach ( $this->classrooms as $cl)

    @php
    $primaryImgUrl = $this->getPrimaryImageUrl($cl);

$name = app()->getLocale() === 'ar' ? $cl->name_ar : $cl->name_fr;

     @endphp
     <div class="classroom">
            <div class="classroom__img">
             <img src="{{ $primaryImgUrl }}" alt="classroom">
              </div>
    <div class="classroom__content">
       <div class="classroom__infos">
        <p>{{ $name}} </p>
          <p>@lang("pages.classroom.classroom.capacity") : {{ $cl->capacity }} </p>
          <p>@lang("pages.classroom.classroom.o-hour")  {{ app('my_constants')['HOURS'][$cl->open_time] }}</p>
           <p>@lang("pages.classroom.classroom.o-hour")  {{ app('my_constants')['HOURS'][$cl->close_time] }}</p>
        </div>
        <div class="classroom__actions">
        <a href="{{ route('classroom', $cl->id) }}" class="button button rounded transparent">
          <span><i class="fa-regular fa-eye"></i></span>
        </a>
      </div>

    </div>
  </div>
  @endforeach
  @endif

</div>
{{ $this->classrooms->links('components.pagination') }}
  </div>
