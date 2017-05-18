<?php
Route::group
(
    [
        'middleware' => 'web',
        'namespace' => 'App\Modules\Document\Http\Controllers'
    ],
    function()
    {
        Route::get('/doc/read/{name}', 'DocumentController@read');
        Route::post('/doc/create/', 'DocumentController@create');
        Route::post('/doc/update/', 'DocumentController@update');
        Route::post('/doc/destroy/', 'DocumentController@destroy');
    }
);
