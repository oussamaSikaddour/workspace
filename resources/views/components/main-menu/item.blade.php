@props(['route','routeName','icon','badge'=>null,'badgeClass'=>''])

@php
    $iconsArray=app('my_constants')['ICONS'];
    $active = Route::is($route) ? 'active' : '';

@endphp
<li role="presentation" class="menu__item  {{ $active }}">
    <a role="menuitem" href="{{ route($route) }}" tabindex="0">
        {{ $routeName }}


        <span>
            @if (array_key_exists($icon, $iconsArray))

           {!!$iconsArray[$icon]!!}
            @endif
        </span>
       @if($badge)
        <x-badge :badge="$badge" class="{{ $badgeClass }}" />
        @endif
 </a>
  </li>
