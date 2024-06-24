

@extends("layouts.root-layout")
@section("content")
<x-custom-layout.header />
@auth
@can('admin-access')
<x-main-menu.open-btn   html_id="mainMenuPhoneBtn" class="menu__btn--phone"/>
<x-main-menu.main-menu/>
@endcan
@endauth

@yield("pageContent")


@endsection
