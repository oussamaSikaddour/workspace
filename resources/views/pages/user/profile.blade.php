@extends('layouts.default-layout')
@section('pageContent')
<section class="section">
    <h2>@lang('pages.profile.page-title')</h2>
    <livewire:admin.user-modal id="{{ auth()->user()->id }}"/>
  </section>
@endsection
