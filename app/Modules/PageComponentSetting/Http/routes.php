<?php

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/PageComponentSetting/PageComponentSettingAdminController/',
    'namespace' => 'App\Modules\PageComponentSetting\Http\Controllers'
    ],
    function()
    {
        Route::post('update/', 'PageComponentSettingAdminController@update')
        ->middleware('auth.admin:section,Page,isUpdate');
    }
);
