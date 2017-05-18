<?php
Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => '_api/Page/PageAdminController/',
        'namespace' => 'App\Modules\Page\Http\Controllers'
    ],
    function()
    {
        Route::get('tree/', 'PageAdminController@tree')
        ->middleware('auth.admin:section,Page,isRead');

        Route::post('create/', 'PageAdminController@create')
        ->middleware('auth.admin:section,Page,isCreate');

        Route::post('update/', 'PageAdminController@update')
        ->middleware('auth.admin:section,Page,isUpdate');

        Route::post('destroy/', 'PageAdminController@destroy')
        ->middleware('auth.admin:section,Page,isDestroy');
    }
);
