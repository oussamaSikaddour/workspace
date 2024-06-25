
<section class="classrooms" id="classrooms">

    @if (count($this->ourClassrooms()) > 0)
    <div class="classrooms__header">
        <h1>
            @lang("pages.landing.links.classrooms")
        </h1>

        <a href="{{ route("classroomsPages") }}">@lang('nav.see-all')</a>

      </div>

    <div class="classrooms__container">

        @foreach ( $this->ourClassrooms() as $cl)

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
    </div>
@endif
  </section>
