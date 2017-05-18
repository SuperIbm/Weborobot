<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Seo/SeoAdminController/',
    'namespace' => 'App\Modules\Seo\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'SeoAdminController@read')
        ->middleware('auth.admin:section,Seo,isRead');
    }
);
