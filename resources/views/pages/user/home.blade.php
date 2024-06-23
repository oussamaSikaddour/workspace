@extends('layouts.default-layout')
@section('pageContent')
<section class="section">
    <h2>@lang('pages.user-space.page-title')</h2>


    <livewire:reservations-table
 />
  </section>
@endsection
