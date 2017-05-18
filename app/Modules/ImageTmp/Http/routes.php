<?php
Route::group
(
    [
    'middleware' => ['web'],
    'namespace' => 'App\Modules\ImageTmp\Http\Controllers'
    ],
    function()
    {
        Route::get('/imgTmp/read/', 'ImageTmpController@read');
        Route::post('/imgTmp/create/', 'ImageTmpController@create');
        Route::post('/imgTmp/update/', 'ImageTmpController@update');
        Route::post('/imgTmp/destroy/', 'ImageTmpController@destroy');
    }
);
