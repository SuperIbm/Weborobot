<?php
Route::group
(
    [
    'middleware' => 'web',
    'namespace' => 'App\Modules\Admin\Http\Controllers'
    ],
    function()
    {
    Route::get('admin/', 'AdminController@index');
    }
);
