<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Cache/CacheController/',
    'namespace' => 'App\Modules\Cache\Http\Controllers'
    ],
    function()
    {
        Route::post('destroy/', 'CacheController@destroy')
        ->middleware('auth.admin');
    }
);
