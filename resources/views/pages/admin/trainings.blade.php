@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <h2>@lang("pages.trainings.page-title")</h2>
    <div>
        <livewire:open-modal-button
        :title="__('modals.training.for.add')"
        classes="button--primary"
        content="<i class='fa-solid fa-briefcase'></i>"
        :data="$modalData"
    />
</div>
<livewire:admin.trainings-table

 />

  </section>
@endsection




