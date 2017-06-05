<?php
/**
 * Модуль Наследование компонентов.
 * Этот модуль содержит все классы для работы с наследованием компонентов.
 * @package App.Modules.Inherit
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Inherit\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;

/**
 * Класс контроллер для работы с наследованием компонентов.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InheritController extends Controller
{
    /**
     * Получение унаследованных компонентов.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function get(Request $Request)
    {
    return view('app.test', ['TEXT' => 'I am here!']);
    }
}
