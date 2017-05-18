<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Access/AccessAdminController/',
    'namespace' => 'App\Modules\Access\Http\Controllers'
    ],
    function()
    {
        Route::get('gate/', 'AccessAdminController@gate');
        Route::post('attempt/', 'AccessAdminController@attempt');
        Route::post('logout/', 'AccessAdminController@logout')
        ->middleware('auth.admin');
    }
);
