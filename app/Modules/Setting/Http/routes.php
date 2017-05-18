<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Setting/SettingAdminController/',
    'namespace' => 'App\Modules\Setting\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'SettingAdminController@read')
        ->middleware('auth.admin:section,Setting,isRead');

        Route::post('update/', 'SettingAdminController@update')
        ->middleware('auth.admin:section,Setting,isUpdate');
    }
);
