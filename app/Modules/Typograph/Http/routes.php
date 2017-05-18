<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Typograph/TypographAdminController/',
    'namespace' => 'App\Modules\Typograph\Http\Controllers'
    ],
    function()
    {
        Route::get('get/', 'TypographAdminController@get')
        ->middleware('auth.admin');
    }
);
