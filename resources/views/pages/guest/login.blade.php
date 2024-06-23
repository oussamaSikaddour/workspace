@extends('layouts.default-layout')
@section('pageContent')
<section class="section">
    <h2>@lang('pages.login.main-title')</h2>
    <div class="form__container small ">
<livewire:guest.login />
    </div>
</section>
@endsection


