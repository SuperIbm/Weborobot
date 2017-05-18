<?php

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Upload/UploadAdminController/',
    'namespace' => 'App\Modules\Upload\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'UploadAdminController@read')
        ->middleware('auth.admin:section,Upload,isRead');

        Route::post('check/', 'UploadAdminController@check')
        ->middleware('auth.admin:section,Upload,isUpdate');

        Route::post('set/', 'UploadAdminController@set')
        ->middleware('auth.admin:section,Upload,isUpdate');
    }
);


Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Upload/UploadSourceAdminController/',
    'namespace' => 'App\Modules\Upload\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'UploadSourceAdminController@read')
        ->middleware('auth.admin:section,Upload,isRead');

        Route::post('create/', 'UploadSourceAdminController@create')
        ->middleware('auth.admin:section,Upload,isCreate');

        Route::post('update/', 'UploadSourceAdminController@update')
        ->middleware('auth.admin:section,Upload,isUpdate');

        Route::post('destroy/', 'UploadSourceAdminController@destroy')
        ->middleware('auth.admin:section,Upload,isDestroy');
    }
);
