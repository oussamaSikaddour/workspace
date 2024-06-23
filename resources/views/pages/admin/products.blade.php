@extends('layouts.default-layout')
@section('pageContent')

<section class="section">
    <h2>@lang("pages.products.page-title")</h2>
    <div>
        <livewire:open-modal-button
        :title="__('modals.product.for.add')"
        classes="button--primary"
        content="<i class='fa-solid fa-plus'></i>"
        :data="$modalData"
    />
   </div>

   <livewire:admin.products-table
 />
</section>
@endsection

