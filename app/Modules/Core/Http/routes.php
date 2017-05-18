<?php
Route::group
(
    [
    'middleware' => 'web',
    'namespace' => 'App\Modules\Core\Http\Controllers'
    ],
    function()
    {
    Route::get('/', 'CoreController@index');
    }
);
