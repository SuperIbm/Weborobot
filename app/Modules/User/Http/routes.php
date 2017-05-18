<?php
Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/User/BlockIpAdminController/',
    'namespace' => 'App\Modules\User\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'BlockIpAdminController@read')
        ->middleware('auth.admin:section,User,isRead');

        Route::post('create/', 'BlockIpAdminController@create')
        ->middleware('auth.admin:section,User,isCreate');

        Route::post('update/', 'BlockIpAdminController@update')
        ->middleware('auth.admin:section,User,isUpdate');

        Route::post('destroy/', 'BlockIpAdminController@destroy')
        ->middleware('auth.admin:section,User,isDestroy');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/User/UserGroupAdminController/',
    'namespace' => 'App\Modules\User\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'UserGroupAdminController@read')
        ->middleware('auth.admin:section,User,isRead');

        Route::post('create/', 'UserGroupAdminController@create')
        ->middleware('auth.admin:section,User,isCreate');

        Route::post('update/', 'UserGroupAdminController@update')
        ->middleware('auth.admin:section,User,isUpdate');

        Route::post('destroy/', 'UserGroupAdminController@destroy')
        ->middleware('auth.admin:section,User,isDestroy');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/User/UserRoleAdminController/',
    'namespace' => 'App\Modules\User\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'UserRoleAdminController@read')
        ->middleware('auth.admin:section,User,isRead');

        Route::post('create/', 'UserRoleAdminController@create')
        ->middleware('auth.admin:section,User,isCreate');

        Route::post('update/', 'UserRoleAdminController@update')
        ->middleware('auth.admin:section,User,isUpdate');

        Route::post('destroy/', 'UserRoleAdminController@destroy')
        ->middleware('auth.admin:section,User,isDestroy');
    }
);

Route::group
(
    [
        'middleware' => ['ajax'],
        'prefix' => '_api/User/UserAdminController/',
        'namespace' => 'App\Modules\User\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'UserAdminController@read')
        ->middleware('auth.admin:section,User,isRead');

        Route::post('create/', 'UserAdminController@create')
        ->middleware('auth.admin:section,User,isCreate');

        Route::post('update/', 'UserAdminController@update')
        ->middleware('auth.admin:section,User,isUpdate');

        Route::post('destroy/', 'UserAdminController@destroy')
        ->middleware('auth.admin:section,User,isDestroy');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/User/UserImageAdminController/',
    'namespace' => 'App\Modules\User\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'UserImageAdminController@read')
        ->middleware('auth.admin:section,User,isRead');

        Route::post('create/', 'UserImageAdminController@create')
        ->middleware('auth.admin:section,User,isCreate');

        Route::post('destroy/', 'UserImageAdminController@destroy')
        ->middleware('auth.admin:section,User,isDestroy');
    }
);