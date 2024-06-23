<a class="nav__logo" href="{{ route('homePage') }}"  tabindex="0"  aria-label="Description of the overall image"
x-on:logo-updated.window="$wire.$refresh()"

>
    <img src="{{ !$gSettings->logo ? asset('img/logo.png') : $gSettings->logo->url }}" alt="app Logo">
</a>
