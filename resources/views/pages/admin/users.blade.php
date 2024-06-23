@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <div>

        <livewire:open-modal-button
        :title="__('pages.users.add-user')"
        classes="button--primary"
        content="<i class='fa-solid fa-users'></i>"
        :data="$modalData"
    />
     </div>


     <livewire:admin.users-table
     :showForSuperAdmin="true"
      {{-- lazy --}}
      />
  <div>

  </section>
@endsection

