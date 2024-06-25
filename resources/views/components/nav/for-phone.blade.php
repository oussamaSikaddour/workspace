
@props(['currentRoute'=>""])
<nav class="nav--phone" aria-labelledby="main-nav-phone">
    <h2 id="main-nav-phone" class="sr-only">
        Main navigation
    </h2>
    <ol class="nav__items">
@auth
              @if ($currentRoute ==="homePage")
              <x-nav.direct-nav-link href="#hero" :label="__('pages.landing.links.hero')"/>
              <x-nav.direct-nav-link href="#aboutUs" :label="__('pages.landing.links.about-us')"/>
              <x-nav.direct-nav-link href="#trainings" :label="__('pages.landing.links.trainings')"/>
              <x-nav.direct-nav-link href="#classrooms" :label="__('pages.landing.links.classrooms')"/>
              <x-nav.direct-nav-link href="#products" :label="__('pages.landing.links.products')"/>
              <x-nav.direct-nav-link href="#contactUs" :label="__('pages.landing.links.contact-us')"/>
              @else
              <x-nav.nav-link
              route="homePage"
              :label="__('nav.accueil')"
                 />
              @endif
            <x-nav.nav-link
                    route="home"
                    :label="__('nav.user-space')"
            />
         @can('admin-access')
             <x-nav.nav-link
                     route="dashboard"
                     :label="__('nav.dashboard')"
             />
        @endcan
        <livewire:user.notifications-btn/>
        <livewire:user.user-nav-btn  />

@endauth
@guest





             @if ($currentRoute ==="homePage")
             <x-nav.direct-nav-link href="#hero" :label="__('pages.landing.links.hero')"/>
             <x-nav.direct-nav-link href="#aboutUs" :label="__('pages.landing.links.about-us')"/>
             <x-nav.direct-nav-link href="#trainings" :label="__('pages.landing.links.trainings')"/>
             <x-nav.direct-nav-link href="#classrooms" :label="__('pages.landing.links.classrooms')"/>
             <x-nav.direct-nav-link href="#products" :label="__('pages.landing.links.products')"/>
             <x-nav.direct-nav-link href="#contactUs" :label="__('pages.landing.links.contact-us')"/>
             @else
             <x-nav.nav-link
             route="homePage"
             :label="__('nav.accueil')"
               />

             @endif
            <x-nav.nav-link
                   route="loginPage"
                   :label="__('nav.login')"
             />
            <x-nav.nav-link
                    route="registerPage"
                    :label="__('nav.register')"
            />
@endguest
<livewire:lang-menu wire:key="lmp"/>
</ol>
</nav>
