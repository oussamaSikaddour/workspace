@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <h2>@lang("pages.classrooms.page-title")</h2>
    <div>
        <livewire:open-modal-button
        :title="__('pages.dashboard.add-classroom')"
        classes="button--primary"
        content="<i class='fa-solid fa-briefcase'></i>"
        :data="$modalData"
    />
</div>
<livewire:admin.classrooms-table
 {{-- lazy --}}
 />

  </section>
@endsection




