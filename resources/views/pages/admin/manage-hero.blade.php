@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <h2>@lang("pages.manage-hero.page-title")</h2>

    <div >
        <button class="button rounded button--primary">
          <a     href="{{ route("dashboard") }}"><i class="fa-solid fa-arrow-left"></i></a>
        </button>
      </div>

<livewire:admin.hero/>
  </section>
@endsection


