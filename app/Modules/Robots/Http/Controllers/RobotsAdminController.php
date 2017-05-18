<?php
/**
 * Модуль Robots.
 * Этот модуль содержит все классы для работы с Robots.
 * @package App.Modules.Robots
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Robots\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Storage;
use Log;
use Auth;


/**
 * Класс контроллер для файлом robots.txt в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class RobotsAdminController extends Controller
{
    /**
     * Чтение данных.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read()
    {
        if(Storage::disk('root')->exists("robots.txt")) $data = Storage::disk('root')->get("robots.txt");
        else $data = "";

        $data =
        [
            "data" =>
            [
                [
                "id" => 1,
                "text" => $data
                ]
            ],
        "total" => 1,
        "success" => true
        ];

    return response()->json($data);
    }


    /**
     * Добавление данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(Request $Request)
    {
    Storage::disk('root')->put("robots.txt", $Request->input('text'));

        $data =
        [
        "success" => true
        ];

        Log::info('Изменение файла robots.txt.',
            [
            'module' => "Robots",
            'login' => Auth::getUser()->login,
            'type' => 'update'
            ]
        );

    return response()->json($data);
    }
}
