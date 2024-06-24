@extends('layouts.default-layout')

@section('pageContent')
    <section class="section">
        <h2>@lang('pages.register.main-title')</h2>
        <div class="form__container small forMultiForm">
         <div class="forms">
           <livewire:guest.register.first-form  wire:key="r-f-f"/>
           <livewire:guest.register.second-form wire:key="r-s-f" />
        </div>
        </div>
    </section>
@endsection
