<?php
Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => '_api/AdminSection/AdminSectionAdminController/',
        'namespace' => 'App\Modules\AdminSection\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'AdminSectionAdminController@read')
        ->middleware('auth.admin:section,AdminSection,isRead');

        Route::post('update/', 'AdminSectionAdminController@update')
        ->middleware('auth.admin:section,AdminSection,isUpdate');

        Route::post('weight/', 'AdminSectionAdminController@weight')
        ->middleware('auth.admin:section,AdminSection,isUpdate');
    }
);
