

@extends("layouts.root-layout")
@section("content")
<x-custom-layout.header />
@auth
<x-main-menu.open-btn   html_id="mainMenuPhoneBtn" class="menu__btn--phone"/>
<x-main-menu.main-menu/>
@endauth

@yield("pageContent")


@endsection
