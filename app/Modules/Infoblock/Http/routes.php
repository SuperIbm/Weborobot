<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Infoblock/InfoblockAdminController/',
    'namespace' => 'App\Modules\Infoblock\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'InfoblockAdminController@read')
        ->middleware('auth.admin:section,Infoblock,isRead');

        Route::post('create/', 'InfoblockAdminController@create')
        ->middleware('auth.admin:section,Infoblock,isCreate');

        Route::post('update/', 'InfoblockAdminController@update')
        ->middleware('auth.admin:section,Infoblock,isUpdate');

        Route::post('destroy/', 'InfoblockAdminController@destroy')
        ->middleware('auth.admin:section,Infoblock,isDestroy');
    }
);
