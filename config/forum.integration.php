<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    | Here we specify the policy classes to use. Change these if you want to
    | extend the provided classes and use your own instead.
    |
    */

    'policies' => [
        'forum' => Riari\Forum\Policies\ForumPolicy::class,
        'model' => [
            Riari\Forum\Models\Category::class  => App\Policies\Forum\CategoryPolicy::class,
            Riari\Forum\Models\Thread::class    => App\Policies\Forum\ThreadPolicy::class,
            Riari\Forum\Models\Post::class      => App\Policies\Forum\PostPolicy::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application user model
    |--------------------------------------------------------------------------
    |
    | Your application's user model.
    |
    */

    'user_model' => App\User::class,

    /*
    |--------------------------------------------------------------------------
    | Application user name
    |--------------------------------------------------------------------------
    |
    | The attribute to use for the username.
    |
    */

    'user_name' => 'name',

];
