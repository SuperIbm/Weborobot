<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/ModuleTemplate/ModuleTemplateAdminController/',
    'namespace' => 'App\Modules\ModuleTemplate\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'ModuleTemplateAdminController@read')
        ->middleware('auth.admin:section,ModuleTemplate,isRead');

        Route::post('create/', 'ModuleTemplateAdminController@create')
        ->middleware('auth.admin:section,ModuleTemplate,isCreate');

        Route::post('update/', 'ModuleTemplateAdminController@update')
        ->middleware('auth.admin:section,ModuleTemplate,isUpdate');

        Route::post('destroy/', 'ModuleTemplateAdminController@destroy')
        ->middleware('auth.admin:section,ModuleTemplate,isDestroy');
    }
);
