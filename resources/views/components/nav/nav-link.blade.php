@props(['route', 'label','parameter'=>null, "span"=>null])

@php
    $active = Route::is($route) ? 'active' : '';
@endphp

<li class="nav__item {{ $active }}"       role="none">
    <a class="nav__link"
    aria-current="{{$label }}"
    @if($parameter)
    href="{{ route($route,$parameter) }}"
    @else
    href="{{ route($route) }}"
    @endif

    >
    {{  $label  }} @if($span) {!! $span !!} @endif
    </a>
</li>
