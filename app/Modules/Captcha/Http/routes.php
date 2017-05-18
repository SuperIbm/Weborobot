<?php

Route::get('_captcha/',
    function ()
    {
        return response(Captcha::get(["pathToTtf" => "storage/app/zebra.ttf"]))
        ->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
);
