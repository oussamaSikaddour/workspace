@extends('layouts.default-layout')
@section('pageContent')


    <div class="dashboard__links">
        <a href="{{ route("manageLanding") }}" class="dashboard__link">
          <img src="{{ asset('img/landing-page.png') }}" alt="manageLanding">
         <h3>@lang('nav.manage-landing')</h3>
        </a>
        <a href="{{ route('manageHero') }}" class="dashboard__link">
          <img src="./img/social-media.png" alt="Hero">
         <h3>@lang('nav.manage-Hero')</h3>
        </a>
        <a href="{{ route('manageAboutUs') }}" class="dashboard__link">
          <img src="./img/social-media.png" alt="AboutUs">
         <h3>@lang('nav.manage-aboutUs')</h3>
        </a>
        <a href="{{ route('manageSocials') }}" class="dashboard__link">
          <img src="./img/social-media.png" alt="Socials">
         <h3>@lang('nav.manage-socials')</h3>
        </a>
    </div>

@endsection




