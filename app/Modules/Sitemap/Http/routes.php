<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Sitemap/SitemapAdminController/',
    'namespace' => 'App\Modules\Sitemap\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'SitemapAdminController@read')
        ->middleware('auth.admin:section,Sitemap,isRead');

        Route::post('create/', 'SitemapAdminController@create')
        ->middleware('auth.admin:section,Sitemap,isCreate');

        Route::post('scan/', 'SitemapAdminController@scan')
        ->middleware('auth.admin:section,Sitemap,isCreate');
    }
);
