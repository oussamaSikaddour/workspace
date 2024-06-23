@props(['href', 'label', "span"=>null])

@php
    $active = Route::is($href) ? 'active' : '';
@endphp

<li class="nav__item {{ $active }}"  role="none">
    <a class="nav__link"
    aria-current="{{$label }}"
    href="{{ $href }}"
    >
    {{  $label  }} @if($span) {!! $span !!} @endif
    </a>
</li>
