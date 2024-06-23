@extends('layouts.default-layout')
@section('pageContent')

<section class="section noAccess">
<div>
        <h1>@lang('pages.no-access.main-p')</h1>
        <a class="button button--primary rounded" aria-current="logout" href="{{ route("logout") }}">
         <i class="fa-solid fa-house"></i>
        </a>
</div>
</section>

@endsection
