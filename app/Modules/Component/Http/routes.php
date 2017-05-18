<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Component/ComponentAdminController/',
    'namespace' => 'App\Modules\Component\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'ComponentAdminController@read')
        ->middleware('auth.admin:section,Component,isRead');

        Route::post('create/', 'ComponentAdminController@create')
        ->middleware('auth.admin:section,Component,isCreate');

        Route::post('update/', 'ComponentAdminController@update')
        ->middleware('auth.admin:section,Component,isUpdate');
    }
);
