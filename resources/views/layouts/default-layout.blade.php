@extends("layouts.root-layout")
@section("content")
<x-default-layout.header />
@auth
@can('admin-access')
<x-main-menu.open-btn   html_id="mainMenuPhoneBtn" class="menu__btn--phone"/>
<x-main-menu.main-menu/>
@endcan
@endauth

<main class="container">
    @yield("pageContent")
</main>
<livewire:footer />
@endsection
