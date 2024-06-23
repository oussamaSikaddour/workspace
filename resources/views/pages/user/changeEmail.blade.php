@extends('layouts.default-layout')
@section('pageContent')
<section class="section">
    <h2>@lang('pages.change-email.main-title')</h2>
    <div class="form__container small">
        <livewire:user.change-email />
    </div>
</section>
@endsection
