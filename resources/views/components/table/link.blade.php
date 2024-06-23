@props(['route','parameter'=>null,'icon', "newTab"=>false,'toolTipMessage'=>""])

@php
    $iconsArray=app('my_constants')['ICONS'];
    $active = Route::is($route) ? 'active' : '';

@endphp
<button  class="button rounded button--primary  {{ $toolTipMessage !==""?'hasTooltip':''}}">

    @if($toolTipMessage)
    <span
    class="toolTip"
    role="tooltip"
    aria-label="{{ $toolTipMessage }}"
  >
   {{ $toolTipMessage }}
  </span>
    @endif
    <a role="menuitem"
    @if($parameter)
    href="{{ route($route,$parameter) }}"
    @else
    href="{{ route($route) }}"
    @endif
    @if ($newTab)
    target="_blank"
    @endif
>
        <span>
            @if (array_key_exists($icon, $iconsArray))

           {!!$iconsArray[$icon]!!}
            @endif
        </span>
 </a>
</button>
