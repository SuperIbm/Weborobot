<?php

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Publication/PublicationSectionAdminController/',
    'namespace' => 'App\Modules\Publication\Http\Controllers'
    ],
    function()
    {
        Route::get('tree/', 'PublicationSectionAdminController@tree')
        ->middleware('auth.admin:section,Publication,isRead');

        Route::post('create/', 'PublicationSectionAdminController@create')
        ->middleware('auth.admin:section,Publication,isCreate');

        Route::post('update/', 'PublicationSectionAdminController@update')
        ->middleware('auth.admin:section,Publication,isUpdate');

        Route::post('destroy/', 'PublicationSectionAdminController@destroy')
        ->middleware('auth.admin:section,Publication,isDestroy');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Publication/PublicationAdminController/',
    'namespace' => 'App\Modules\Publication\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'PublicationAdminController@read')
        ->middleware('auth.admin:section,Publication,isRead');

        Route::post('create/', 'PublicationAdminController@create')
        ->middleware('auth.admin:section,Publication,isCreate');

        Route::post('update/', 'PublicationAdminController@update')
        ->middleware('auth.admin:section,Publication,isUpdate');

        Route::post('destroy/', 'PublicationAdminController@destroy')
        ->middleware('auth.admin:section,Publication,isDestroy');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Publication/PublicationCommentTreeAdminController/',
    'namespace' => 'App\Modules\Publication\Http\Controllers'
    ],
    function()
    {
        Route::get('tree/', 'PublicationCommentTreeAdminController@tree')
        ->middleware('auth.admin:section,Publication,isRead');

        Route::post('create/', 'PublicationCommentTreeAdminController@create')
        ->middleware('auth.admin:section,Publication,isCreate');

        Route::post('update/', 'PublicationCommentTreeAdminController@update')
        ->middleware('auth.admin:section,Publication,isUpdate');

        Route::post('destroy/', 'PublicationCommentTreeAdminController@destroy')
        ->middleware('auth.admin:section,Publication,isDestroy');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Publication/PublicationCommentAdminController/',
    'namespace' => 'App\Modules\Publication\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'PublicationCommentAdminController@read')
        ->middleware('auth.admin:section,Publication,isRead');
    }
);

Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Publication/PublicationCommentImageAdminController/',
    'namespace' => 'App\Modules\Publication\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'PublicationCommentImageAdminController@read')
        ->middleware('auth.admin:section,Publication,isRead');

        Route::post('create/', 'PublicationCommentImageAdminController@create')
        ->middleware('auth.admin:section,Publication,isCreate');

        Route::post('destroy/', 'PublicationCommentImageAdminController@destroy')
        ->middleware('auth.admin:section,Publication,isDestroy');
    }
);


Route::group
(
    [
    'middleware' => ['ajax'],
    'prefix' => '_api/Publication/PublicationImageAdminController/',
    'namespace' => 'App\Modules\Publication\Http\Controllers'
    ],
    function()
    {
        Route::get('read/', 'PublicationImageAdminController@read')
        ->middleware('auth.admin:section,Publication,isRead');

        Route::post('create/', 'PublicationImageAdminController@create')
        ->middleware('auth.admin:section,Publication,isCreate');

        Route::post('destroy/', 'PublicationImageAdminController@destroy')
        ->middleware('auth.admin:section,Publication,isDestroy');
    }
);
