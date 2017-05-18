<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Filesystem/',
    'namespace' => 'App\Modules\Filesystem\Http\Controllers'
    ],
    function()
    {
        Route::get('FilesystemDirAdminController/read/', 'FilesystemDirAdminController@read')
        ->middleware('auth.admin:section,Filesystem,isRead');

        Route::post('FilesystemDirAdminController/create/', 'FilesystemDirAdminController@create')
        ->middleware('auth.admin:section,Filesystem,isCreate');

        Route::post('FilesystemDirAdminController/update/', 'FilesystemDirAdminController@update')
        ->middleware('auth.admin:section,Filesystem,isUpdate');

        Route::post('FilesystemDirAdminController/move/', 'FilesystemDirAdminController@move')
        ->middleware('auth.admin:section,Filesystem,isUpdate');

        Route::post('FilesystemDirAdminController/destroy/', 'FilesystemDirAdminController@destroy')
        ->middleware('auth.admin:section,Filesystem,isDestroy');

        //

        Route::get('FilesystemFileAdminController/read/', 'FilesystemFileAdminController@read')
        ->middleware('auth.admin:section,Filesystem,isRead');

        Route::post('FilesystemFileAdminController/create/', 'FilesystemFileAdminController@create')
        ->middleware('auth.admin:section,Filesystem,isCreate');

        Route::post('FilesystemFileAdminController/update/', 'FilesystemFileAdminController@update')
        ->middleware('auth.admin:section,Filesystem,isUpdate');

        Route::post('FilesystemFileAdminController/destroy/', 'FilesystemFileAdminController@destroy')
        ->middleware('auth.admin:section,Filesystem,isDestroy');
    }
);
