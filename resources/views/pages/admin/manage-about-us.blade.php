@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <h2>@lang("pages.manage-aboutUs.page-title")</h2>


<div >
        <button class="button rounded button--primary">
          <a     href="{{ route("dashboard") }}"><i class="fa-solid fa-arrow-left"></i></a>
        </button>

        <livewire:open-modal-button
        :title="__('modals.ourQuality.for.add')"
        classes="button--primary"
        content="<i class='fa-solid fa-plus'></i>"
        :data="$modalData"
    />
</div>

<livewire:admin.about-us/>

   <livewire:admin.our-qualities-table

 />
</section>
@endsection
