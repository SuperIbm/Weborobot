<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Widget/WidgetAdminController/',
    'namespace' => 'App\Modules\Widget\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'WidgetAdminController@read')
        ->middleware('auth.admin:section,Widget,isRead');

        Route::post('create/', 'WidgetAdminController@create')
        ->middleware('auth.admin:section,Widget,isCreate');

        Route::post('update/', 'WidgetAdminController@update')
        ->middleware('auth.admin:section,Widget,isUpdate');
    }
);
