
<main class="showcase" >
    <div class="showcase__head">
        <button class="button rounded button--primary" wire:click="goBack()">
            <i class="fa-solid fa-arrow-left"></i>
             </button>
        <h1>{{ $name }}</h1>
    </div>

    <div class="showcase__body">
    <div class="showcase__imgs__container">

      <div class="showcase__img__primary">
        <img src="{{ $imgUrl }}" alt="training">
      </div>
    </div>


  <div class="showcase__content">
    <div class="showcase__header">

    </div>
    @if ($training->trainer)
    <div class="showcase__infos">
      <div class="showcase__info">
        <h2>@lang('pages.training.training.trainer')</h2>
        <ul>
          <li>
             <p>{{ $training->trainer->name }}</p>
            <a class="button rounded hasToolTip"
            href="{{$trainerCv?->url}}"
            target="_blank"
            >
            <span
            class="toolTip"
            role="tooltip"
            aria-label="__('toolTips.user.cv')"
          >
        @lang('toolTips.user.cv')
          </span>
            <i class="fa-solid fa-file-pdf"></i>
            </a>
          </li>
        </ul>
      </div>
      @endif
      <div class="showcase__info">
        <h2>@lang('pages.training.training.capacity')</h2>
        <ul>
          <li>{{ $training->capacity }}</li>
        </ul>

      </div>
      <div class="showcase__info">
        <h2>@lang('pages.training.training.price')</h2>
      <ul>
           <li>
            <p>@lang('pages.training.training.p-per-s')</p>
            <p>{{ $training->price_per_session }}</p>
             <p>@lang('pages.training.training.currency')</p>
            </li>
           <li>
            <p>@lang('pages.training.training.p-t')</p>
            <p>{{ $training->price_total }}</p>
             <p>@lang('pages.training.training.currency')</p>
            </li>

      </ul>
      </div>
      <div class="showcase__info">
        <h2>@lang('pages.training.training.duration')</h2>
      <ul>
        <li>
          <p>@lang('pages.training.training.startAt')</p>
          <p>{{ $training->start_at }}</p>
        </li>
        <li>
          <p>@lang('pages.training.training.endAt')</p>
          <p>{{ $training->end_at }}</p>
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

