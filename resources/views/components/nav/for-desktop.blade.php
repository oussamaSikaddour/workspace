
@props(['currentRoute'=>""])
<header class="header" >
    <nav class="nav" aria-labelledby="main-nav">
        <h2 id="main-nav" class="sr-only">
            Main navigation
        </h2>
@auth
        <div class="nav__addons">
           <x-main-menu.open-btn   html_id="mainMenuDeskTopBtn" />
           <livewire:nav-logo/>
        </div>
        <ol class="nav__items">
            @if ($currentRoute ==="homePage")
            <x-nav.direct-nav-link href="#hero" :label="__('pages.landing.links.hero')"/>
            <x-nav.direct-nav-link href="#aboutUs" :label="__('pages.landing.links.about-us')"/>
            <x-nav.direct-nav-link href="#trainings" :label="__('pages.landing.links.trainings')"/>
            <x-nav.direct-nav-link href="#classRooms" :label="__('pages.landing.links.classrooms')"/>
            <x-nav.direct-nav-link href="#products" :label="__('pages.landing.links.products')"/>
            <x-nav.direct-nav-link href="#contactUs" :label="__('pages.landing.links.contact-us')"/>
            @endif

            <x-nav.nav-link
            route="home"
            :label="__('nav.user-space')"
             />
        </ol>
        <ol class="nav__items">
         @can('admin-access')
                  <x-nav.nav-link
                        route="dashboard"
                       :label="__('nav.dashboard')"
                    />
          @endcan
        <livewire:user.notifications-btn/>
        <livewire:user.user-nav-btn/>
        </ol>

@endauth

 @guest

         <ol class="nav__items">
                 @if ($currentRoute ==="homePage")
                 <x-nav.direct-nav-link href="#hero" :label="__('pages.landing.links.hero')"/>
                 <x-nav.direct-nav-link href="#aboutUs" :label="__('pages.landing.links.about-us')"/>
                 <x-nav.direct-nav-link href="#trainings" :label="__('pages.landing.links.trainings')"/>
                 <x-nav.direct-nav-link href="#classRooms" :label="__('pages.landing.links.classrooms')"/>
                 <x-nav.direct-nav-link href="#products" :label="__('pages.landing.links.products')"/>
                 <x-nav.direct-nav-link href="#contactUs" :label="__('pages.landing.links.contact-us')"/>
                 @else
                 <x-nav.nav-link
                 route="homePage"
                 :label="__('nav.accueil')"
                  />
                 @endif

          </ol>

        <ol class="nav__items">
                 <x-nav.nav-link
                        route="loginPage"
                        :label="__('nav.login')"
                 />
                 <x-nav.nav-link
                         route="registerPage"
                         :label="__('nav.register')"
                 />
        </ol>


@endguest

<livewire:lang-menu wire:key="lmd"/>
</nav>
</header>
