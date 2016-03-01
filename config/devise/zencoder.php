<?php return array(
    /*
    |--------------------------------------------------------------------------
    | API key for zencoder
    |--------------------------------------------------------------------------
    |
    */
    'api-key' => '',

    /*
    |--------------------------------------------------------------------------
    | If we are testing locally then we need some sort of
    | proxy url or else Zencoder cannot reach our development url
    | at http://localhost:8000/media/somefile.mov
    |--------------------------------------------------------------------------
    |
    */
    'callback-url' => 'http://localhost:8000',

    /*
    |--------------------------------------------------------------------------
    | Call back url for zencoder to tell us that our
    | video encoding job has been completed
    |--------------------------------------------------------------------------
    |
    */
    'notifications' => [ 'http://localhost:8000/api/notifications/zencoder' ],

);