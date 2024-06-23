@extends('layouts.default-layout')
@section('pageContent')
    <section class="section">
        <h2>@lang('pages.forget-password.main-title')</h2>
        <div class="form__container small">
         <div class="forms">
           <livewire:guest.forget-password.first-form />
          <livewire:guest.forget-password.second-form />
         </div>
        </div>
    </section>
@endsection

