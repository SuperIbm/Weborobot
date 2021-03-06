<?php
/**
 * Модуль Типографи.
 * Этот модуль содержит все классы для работы с типографом.
 * @package App.Modules.Typograph
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Typograph\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Modules\Typograph\Http\Requests\TypographAdminGetRequest;
use Tttptd\Mdash\Facades\Mdash;


/**
 * Класс контроллер для работы с типографом в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class TypographAdminController extends Controller
{
    /**
     * Получение типографированного текста.
     * @param \App\Modules\Typograph\Http\Requests\TypographAdminGetRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function get(TypographAdminGetRequest $Request)
    {
    $text = str_replace("\t", '', $Request->input('text'));
    $text = str_replace("\n\r", '', $text);
    $text = str_replace("\r\n", '', $text);
    $text = str_replace("\n", '', $text);
    $text = str_replace("\r", '', $text);

        if($text != "")
        {
            $result = Mdash::process($text,
                [
                'OptAlign.all' => false
                ]
            );

            if($result)
            {
                $data = 
                [
                'success' => true,
                'text' => $result
                ];
            }
            else
            {
                $data =
                [
                'success' => false
                ];
            }
        }
        else
        {
            $data =
            [
            'success' => true,
            'text' => ''
            ];
        }

    return response()->json($data);
    }
}
