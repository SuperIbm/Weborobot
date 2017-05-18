<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Module/ModuleAdminController/',
    'namespace' => 'App\Modules\Module\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'ModuleAdminController@read')
        ->middleware('auth.admin:section,Module,isRead');

        Route::post('create/', 'ModuleAdminController@create')
        ->middleware('auth.admin:section,Module,isCreate');

        Route::post('update/', 'ModuleAdminController@update')
        ->middleware('auth.admin:section,Module,isUpdate');

        Route::get('tree/', 'ModuleAdminController@tree')
        ->middleware('auth.admin:section,ModuleTemplate,isRead');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Module/ModuleAndComponentAdminController/',
    'namespace' => 'App\Modules\Module\Http\Controllers'
    ],
    function()
    {
        Route::get('tree/', 'ModuleAndComponentAdminController@tree')
        ->middleware('auth.admin');
    }
);
