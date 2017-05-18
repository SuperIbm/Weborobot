<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/PageTemplate/PageTemplateAdminController/',
    'namespace' => 'App\Modules\PageTemplate\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'PageTemplateAdminController@read')
        ->middleware('auth.admin:section,PageTemplate,isRead');

        Route::post('create/', 'PageTemplateAdminController@create')
        ->middleware('auth.admin:section,PageTemplate,isCreate');

        Route::post('update/', 'PageTemplateAdminController@update')
        ->middleware('auth.admin:section,PageTemplate,isUpdate');

        Route::post('destroy/', 'PageTemplateAdminController@destroy')
        ->middleware('auth.admin:section,PageTemplate,isDestroy');
    }
);
