<?php
/**
 * Модуль Ядро административной системы.
 * Этот модуль содержит все классы для работы с ядром административной системы.
 * @package App.Modules.AdminSection
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Admin\Http\Controllers;

use Illuminate\Routing\Controller;
use Config;
use Log;

/**
 * Класс контроллер для ядра административной системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AdminController extends Controller
{
    /**
     * Отобразить главный шаблон административной системы.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function index()
    {
        return view('admin::template',
            [
            'DOMAN_NAME' => Config::get('app.url')
            ]
        );
    }
}
