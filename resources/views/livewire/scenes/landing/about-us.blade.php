@php
            $title = app()->getLocale() === 'ar' ? $aboutUs->title_ar : $aboutUs->title_fr;
            $description = app()->getLocale() === 'ar' ? $aboutUs->description_ar : $aboutUs->description_fr;
@endphp
<section id="aboutUs" class="about-us">
    <div class="about-us__body">
    <img src="./img/aboutUs.jpg" alt="hospital">

    <div class="about-us__content">
      <h1>
      {{ $title }}
      </h1>
      <p>
        {{ $description }}
      </p>
    </div>
  </div>

  @if (  count($this->qualities) >0 )

  <ul class="about-us__qualities">

    @foreach ($this->qualities as $q)

    @php
        $name = app()->getLocale() === 'ar' ? $q->name_ar : $q->name_fr;
    @endphp
    <li class="about-us__qualitie">
        <img src="{{ $q->image?->url }}" alt="{{ $name }}">
        <p>{{ $name }}</p>
      </li>
    @endforeach
  </ul>
  @endif


</section>
