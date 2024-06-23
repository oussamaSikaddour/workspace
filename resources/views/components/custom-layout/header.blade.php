@php
    $currentRoute= $currentRoute=Route::currentRouteName();
@endphp
<x-nav.for-desktop :$currentRoute/>
<x-nav.hamburger-button/>
<x-nav.for-phone  :$currentRoute/>
{{-- <livewire:lang-menu :forCustom="true" wire:key="PGLM"/> --}}
