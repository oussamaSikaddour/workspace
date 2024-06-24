@extends('layouts.default-layout')

@section('pageContent')
    <section class="section">
        <h2>@lang("pages.site-params.main-title")</h2>
        <div class="form__container small forMultiForm">
   <div class="forms">
    <livewire:admin.site-parameters.first-form />
    <livewire:admin.site-parameters.second-form />
   </div>

    </div>
    </section>
@endsection
