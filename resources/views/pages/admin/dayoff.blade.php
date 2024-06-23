@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <h2>@lang("pages.dayoff.page-title")</h2>


    <div  >
        <button class="button rounded button--primary">
          <a     href="{{ route("classrooms") }}"><i class="fa-solid fa-arrow-left"></i></a>
        </button>

      </div>
    <div>
        <livewire:open-modal-button
        :title="__('modals.days-off.for.add')"
        classes="button--primary"
        content="<i class='fa-solid fa-umbrella-beach'></i>"
        :data="$modalData"
    />
   </div>

   <livewire:admin.days-off-table
   :$classroomId
 />

</section>
@endsection

