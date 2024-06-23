@extends('layouts.default-layout')
@section('pageContent')
<section class="section">
    <h2>@lang('pages.change-password.main-title')</h2>
    <div class="form__container small">
        <livewire:user.change-password />
    </div>
</section>
@endsection

