<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Robots/RobotsAdminController/',
    'namespace' => 'App\Modules\Robots\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'RobotsAdminController@read')
        ->middleware('auth.admin:section,Robots,isRead');

        Route::post('create/', 'RobotsAdminController@create')
        ->middleware('auth.admin:section,Robots,isCreate');
    }
);
