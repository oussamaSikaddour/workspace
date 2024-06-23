<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default user role
    |--------------------------------------------------------------------------
    |
    | This value is the default user role id that will be assigned to new users
    | when they register.
    |
    | admin = Admin role, user = User role, customer = Customer Role - Check RoleSeeder for more
    |
    */

    'default_role_slug' => env('DEFAULT_ROLE_SLUG', 'user'),

    /*
    |--------------------------------------------------------------------------
    | Delete old access tokens when logged in
    |--------------------------------------------------------------------------
    |
    | This value determines whether or not to delete old access tokens when
    | the users are logged in.
    |
    */

    'delete_previous_access_tokens_on_login' => env('DELETE_PREVIOUS_ACCESS_TOKENS_ON_LOGIN', false),
];
