<section class="trainings" id="trainings">

    @if (  count($this->ourTrainings()) >0 )


    <div class="trainings__header">
        <h1>@lang("pages.landing.links.trainings")</h1>
        <a href="{{ route("trainingsPages") }}">@lang('nav.see-all')</a>

      </div>

    <div class="trainings__container">

        @foreach ($this->ourTrainings() as $tr )
@php
    $name = app()->getLocale() === 'ar' ? $tr->name_ar : $tr->name_fr;
@endphp

      <div class="training">
        <div class="training__cover">
          <img src="{{ $tr->image->url }}" alt="{{ $name }}" />
        </div>
        <div class="training__content">

            <h2>{{ $name }}</h2>
             <div class="training__actions">
                <a  href="{{ route('training',$tr->id) }}" class="button  rounded transparent">
                 <span><i class="fa-regular fa-eye"></i></span>
                </a>
             </div>

        </div>

      </div>
      @endforeach
    </div>
@endif
  </section>
