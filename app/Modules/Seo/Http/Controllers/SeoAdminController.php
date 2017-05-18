<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Http\Controllers;

use Carbon\Carbon;
use Seo;

use Illuminate\Routing\Controller;
use App\Modules\Seo\Http\Requests\SeoAdminReadRequest;


/**
 * Класс контроллер для работы со статистикой сайта в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SeoAdminController extends Controller
{
    /**
     * Чтение данных.
     * @param \App\Modules\Seo\Http\Requests\SeoAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(SeoAdminReadRequest $Request)
    {
        if($Request->input('dateFrom')) $DateFrom = Carbon::createFromFormat('Y-m-d', $Request->input('dateFrom'));
        else $DateFrom = null;

        if($Request->input('dateTo')) $DateTo = Carbon::createFromFormat('Y-m-d', $Request->input('dateTo'));
        else $DateTo = null;

    $data = Seo::take($Request->input('detalization'), $Request->input('date'), $DateFrom, $DateTo);

        if($data !== false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => count($data),
            'success' => true
            ];
        }
        else
        {
            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }
}
