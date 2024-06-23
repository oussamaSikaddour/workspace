
<main class="showcase" wire:ignore>
    <div class="showcase__head">
        <div>

        <button class="button rounded button--primary" wire:click="goBack()">
       <i class="fa-solid fa-arrow-left"></i>
        </button>
         <livewire:open-modal-button
          :toolTipMessage="__('modals.reservation.for.add')"
           classes="button--primary rounded"
            content="<i class='fa-solid fa-check'></i>"
           :data="$modalData"
           />
      </div>

        <h1>{{ $name }}</h1>
    </div>

    <div class="showcase__body">
    <div class="showcase__imgs__container">

      <div class="showcase__img__primary">
        <img src="{{ $primaryImgUrl }}" alt="classroom">
      </div>

      <div class="showcase__imgs" >

        @foreach ($classroom->images as $image )
        <div class="showcase__img"  wire:click="setPrimaryImage({{ $image->id }})">
            <img src="{{ $image->url }}" alt="classroom" id="{{ $image->id }}-p-img">
          </div>
        @endforeach

      </div>
    </div>


  <div class="showcase__content">

    <div class="showcase__infos">
      <div class="showcase__info">
        <h2>@lang('pages.classroom.classroom.capacity')</h2>
        <ul>


   <li><p>{{ $classroom->capacity }}</p></li>


        </ul>

      </div>
      <div class="showcase__info">
        <h2>@lang('pages.classroom.classroom.workingdays')</h2>
        <ul>
   @foreach ( $workingDays as $wd )

   <li>{{   app('my_constants')['WEEK_DAYS'][app()->getLocale()][$wd] }}</li>

   @endforeach
        </ul>

      </div>
      <div class="showcase__info">
        <h2>@lang('pages.classroom.classroom.workingHours')</h2>
        <ul>
            <li>
            <p>@lang('pages.classroom.classroom.o-hour')</p>
            <p>{{   app('my_constants')['HOURS'][$classroom->open_time] }}</p>
            </li>
            <li>
            <p>@lang('pages.classroom.classroom.c-hour')</p>
            <p>{{   app('my_constants')['HOURS'][$classroom->close_time] }}</p>
            </li>
        </ul>

      </div>
      <div class="showcase__info">
        <h2>@lang('pages.classroom.classroom.price')</h2>
      <ul>
        <li>
            <p>@lang('pages.classroom.classroom.p-per-h')</p>
            <p>{{ $classroom->price_per_hour }}</p>
             <p>@lang('pages.classroom.classroom.currency')</p>
            </li>
        <li>
            <p>@lang('pages.classroom.classroom.p-per-d')</p>
            <p>{{ $classroom->price_per_day }}</p>
             <p>@lang('pages.classroom.classroom.currency')</p>
            </li>
        <li>
            <p>@lang('pages.classroom.classroom.p-per-w')</p>
            <p>{{ $classroom->price_per_week }}</p>
             <p>@lang('pages.classroom.classroom.currency')</p>
            </li>
        <li>
            <p>@lang('pages.classroom.classroom.p-per-m')</p>
            <p>{{ $classroom->price_per_month }}</p>
             <p>@lang('pages.classroom.classroom.currency')</p>
            </li>
      </ul>
      </div>
      </div>

    <div class="showcase__description">
{!!  $description !!}
    </div>



  </div>

</div>


  </main>

