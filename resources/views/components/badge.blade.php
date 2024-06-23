@props(['badge'])
<span
{{ $attributes->merge(['class'=>"badge"]) }}>
    {{ $badge }}
</span>
