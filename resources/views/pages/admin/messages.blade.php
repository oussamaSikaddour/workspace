@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <h2>@lang("pages.messages.page-title")</h2>

<livewire:admin.messages-table
 {{-- lazy --}}
 />

  </section>
@endsection




