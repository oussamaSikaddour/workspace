
@php
   $logoUrl = $gSettings->logo->url ?? "";
@endphp

@extends("layouts.custom-layout")
@section("pageContent")


<livewire:carousel :showControls=false :$slides  variant="carousel--landing" wire:key="ca-Land"/>

  {{-- <livewire:scenes.landing.hero :$logoUrl/>
  <livewire:scenes.landing.about-us/>
  <livewire:scenes.landing.trainings/> --}}
  <livewire:scenes.landing.class-rooms/>
  {{-- <livewire:scenes.landing.products />
  <livewire:scenes.landing.contact-us :map="$gSettings->map"/> --}}

  <footer class="landing__footer">
    @if($gSettings)
<div>


    <div class="contact">
      <span><i class="fa-solid fa-envelope"></i></span>
      <p>{{ $gSettings->email}}</p>
    </div>
    <div class="contact">
      <span><i class="fa-solid fa-mobile"></i></span>
      <p>{{ $gSettings->phone}}</p>
    </div>
    <div class="contact">
      <span><i class="fa-solid fa-phone"></i></span>
      <p>{{ $gSettings->landline}}</p>
    </div>
    <div class="contact">
      <span><i class="fa-solid fa-fax"></i></span>
      <p>{{ $gSettings->fax}}</p>
    </div>
  </div>


<div>
  <livewire:socials />

    <div>
      <p class="text-light">&#169; SO 2023 - {{ date('Y'); }}</p><a href="index.html"><img class="logo" src="{{ $gSettings->logo?->url }}" /></a>
    </div>
    @endif
</div>
  </footer>
@endsection
