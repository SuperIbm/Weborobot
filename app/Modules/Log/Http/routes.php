<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Log/LogAdminController/',
    'namespace' => 'App\Modules\Log\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'LogAdminController@read')
        ->middleware('auth.admin:section,Log,isRead');
    }
);
