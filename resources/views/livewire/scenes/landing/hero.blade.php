@php
            $title = app()->getLocale() === 'ar' ? $hero->title_ar : $hero->title_fr;
            $subTitle = app()->getLocale() === 'ar' ? $hero->sub_title_ar : $hero->sub_title_fr;
@endphp

<section class="hero" id="hero">

    <img src="{{ $logoUrl ===""?"./img/Logo.png": $logoUrl }}" alt="logo" class="hero__logo">
    <div class="hero__content">
       <div>
          <h1>{{ $title }}</h1>
          <h2>{{ $subTitle }}</h2>
        </div>
      <div class="hero__actions">


        @auth
            <a class="button" href="{{ route('home') }}">
                @lang("nav.user-space")
            </a>
        @endauth
        @guest
        <a class="button button--primary" href="{{ route('loginPage') }}">
            @lang("nav.login")
            </a>
            <a class="button" href="{{ route('registerPage') }}">
                @lang("nav.register")
            </a>
        @endguest

      </div>
  </div>

  <a href="#aboutUs" class="hero__arrow">
    <img src="{{ asset("img/triangle.png") }}" alt="triangle">
  </a>
</section>
