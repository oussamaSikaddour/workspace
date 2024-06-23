<div class="menu">
    <ul id="mainMenu" role="menu" aria-labelledby="menubutton" class="menu__items">
        @can('admin-access')
        <x-main-menu.item
             route="messages"
            :routeName="__('nav.messages')"
             icon="message"
          />
        <x-main-menu.item
             route="users"
            :routeName="__('nav.users')"
             icon="users"
          />
        <x-main-menu.item
             route="classrooms"
            :routeName="__('nav.classrooms')"
             icon="classrooms"

          />
        <x-main-menu.item
             route="trainings"
            :routeName="__('nav.trainings')"
             icon="trainings"
          />
        <x-main-menu.item
             route="products"
            :routeName="__('nav.products')"
             icon="products"

          />
        @endcan
      </ul>
</div>

