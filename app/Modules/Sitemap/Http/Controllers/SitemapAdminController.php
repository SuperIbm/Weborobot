<?php
/**
 * Модуль Sitemap.
 * Этот модуль содержит все классы для работы с sitemap.
 * @package App.Modules.Sitemap
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Sitemap\Http\Controllers;

use App\Modules\Sitemap\Models\Sitemap;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Storage;
use Log;
use Auth;

/**
 * Класс контроллер для работы с Sitemap в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SitemapAdminController extends Controller
{
    /**
     * Чтение данных.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read()
    {
        if(Storage::disk('root')->exists("sitemap.xml")) $data = Storage::disk('root')->get("sitemap.xml");
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
    Storage::disk('root')->put("sitemap.xml", $Request->input('text'));

        $data =
        [
        "success" => true
        ];

        Log::info('Изменение файла sitemap.xml.',
            [
            'module' => "Sitemap",
            'login' => Auth::getUser()->login,
            'type' => 'update'
            ]
        );

    return response()->json($data);
    }


    /**
     * Сканирование сайта.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function scan()
    {
    $Sitemap = new Sitemap();
    $pages = $Sitemap->scan();

        if($pages)
        {
            $xml = view('sitemap::sitemap',
                [
                'SITEMAP' =>
                    [
                    'pages' => $pages
                    ]
                ]
            );

        Storage::disk('root')->put("sitemap.xml", $xml);
        }

        $data =
        [
        'success' => true,
        "text" => Storage::disk('root')->get("sitemap.xml")
        ];

        Log::info('Сканирование сайта для создания sitemap.xml.',
            [
            'module' => "Sitemap",
            'login' => Auth::getUser()->login,
            'type' => 'scan'
            ]
        );

    return response()->json($data);
    }
}
