<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/PageComponent/PageComponentAdminController/',
    'namespace' => 'App\Modules\PageComponent\Http\Controllers'
    ],
    function()
    {
        Route::get('tree/', 'PageComponentAdminController@tree')
        ->middleware('auth.admin:section,Page,isRead');

        Route::post('create/', 'PageComponentAdminController@create')
        ->middleware('auth.admin:section,Page,isCreate');

        Route::post('weight/', 'PageComponentAdminController@weight')
        ->middleware('auth.admin:section,Page,isUpdate');

        Route::post('destroy/', 'PageComponentAdminController@destroy')
        ->middleware('auth.admin:section,Page,isDestroy');
    }
);
