<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Alias/AliasAdminController/',
    'namespace' => 'App\Modules\Alias\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'AliasAdminController@read')
        ->middleware('auth.admin:section,Alias,isRead');

        Route::post('create/', 'AliasAdminController@create')
        ->middleware('auth.admin:section,Alias,isCreate');

        Route::post('update/', 'AliasAdminController@update')
        ->middleware('auth.admin:section,Alias,isUpdate');

        Route::post('destroy/', 'AliasAdminController@destroy')
        ->middleware('auth.admin:section,Alias,isDestroy');
    }
);
