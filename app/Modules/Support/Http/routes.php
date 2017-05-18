<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Support/SupportAdminController/',
    'namespace' => 'App\Modules\Support\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'SupportAdminController@read')
        ->middleware('auth.admin:section,Support,isRead');

        Route::post('update/', 'SupportAdminController@update')
        ->middleware('auth.admin:section,Support,isUpdate');

        Route::post('send/', 'SupportAdminController@send')
        ->middleware('auth.admin');
    }
);
