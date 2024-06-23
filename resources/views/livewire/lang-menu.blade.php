<div class="lang__menu__container {{ $forCustom ? 'phone' : '' }}">
    <button id="menuLangbutton"   aria-haspopup="true" aria-controls="menu" class="lang__btn button">
    </button>
    <ul id="langMenu" role="menu" aria-labelledby="menubutton" class="lang__menu">
    </ul>
  </div>


@script
  <script>
  document.addEventListener('set-locale', function(event) {
        @this.setLocale(event.detail.data.lang);
    });

  </script>
@endscript
