<footer class="footer"
x-on:logo-updated.window="$wire.$refresh()"
>

    <p class="text-light">&#169; SO 2023 - {{ $currentYear }}
    </p><a href="#"><img class="logo"
        src="{{ !$gSettings->logo ? asset('img/logo.png') : $gSettings->logo->url }}" /></a>
</footer>
