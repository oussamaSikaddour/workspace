@props(['items' => [], 'dropdownLink'])

@php
    $iconsArray=app('my_constants')['ICONS'];
@endphp

<li class="nav__item nav__item--dropDown">
    <div id="subNav-btn"
    tabindex="0"
    class="nav__btn nav__btn--dropdown"
    aria-expanded="false" aria-controls="subItems"
    aria-label="Show user menu"
    aria-labelledby="subNav-btn">
        {!! $dropdownLink !!}
    </div>
    <ul id="subItems" class="nav__items--sub" hidden role="menu">
        @foreach ($items as $item)
            <li role="none">
                <a href="{{ $item['route'] }}"  role="menuitem">
                    {{ $item['label'] }}
                    @if (array_key_exists('icon', $item)
                    && array_key_exists($item['icon'],$iconsArray))
                   {!! $iconsArray[$item['icon']]!!}
                    @endif
                </a>

            </li>
        @endforeach

        {{ $slot }}
    </ul>
</li>
