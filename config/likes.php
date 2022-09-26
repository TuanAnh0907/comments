<?php

return [

    /**
     * To extend the base Comment model one just needs to create a new
     * CustomComment model extending the Comment model shipped with the
     * package and change this configuration option to their extended model.
     */
    'model' => \TuanAnh0907\Comments\Like::class,

    /**
     * You can customize the behaviour of these permissions by
     * creating your own and pointing to it here.
     */
    'permissions' => [

    ],

    'controller' => '\TuanAnh0907\Comments\LikeController',

    'routes' => true,

    'approval_required' => false,

    'guest_commenting' => false,

    'soft_deletes' => false,

    'load_migrations' => true,

    'paginator_use_bootstrap' => true,

];
