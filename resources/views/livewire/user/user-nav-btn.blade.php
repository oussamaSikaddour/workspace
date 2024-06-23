
@php

$userImage = '<img src="' . $userProfilePicUrl . '" alt="profile Picture">';
$userDropdownLink = $userName . $userImage;
@endphp
<x-nav.dropdown-nav-link
x-on:update-nav-user-btn.window="$wire.$refresh()"
:items="[
          [
            'route'=>route('profile'),
            'label'=>__('nav.profile'),
            'icon'=>'profile'
          ],
         [
            'route' => route('changePassword'),
            'label' => __('nav.changePassword')
        ],
         [
            'route' => route('changeEmail'),
            'label' => __('nav.changeEmail')
        ],
        [
            'route'=>route('logout'),
            'label'=>__('nav.logout'),
            'icon'=>'logout'
        ]
       ]"
:dropdownLink="$userDropdownLink"/>
