<?php
/**
 * Модуль Кеширования.
 * Этот модуль содержит все классы для работы с кешированием.
 * @package App.Modules.Cache
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Cache\Http\Controllers;

use Illuminate\Routing\Controller;
use Cache;
use Log;
use Auth;

/**
 * Класс контроллер для ядра административной системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CacheController extends Controller
{
    /**
     * Удаление всех закешированных данных.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy()
    {
    Cache::flush();

        Log::info('Удаление кеша.',
            [
            "login" => Auth::getUser()['login'],
            "module" => "Cache",
            'type' => 'destroy'
            ]
        );

    return response()->json(['success' => true]);
    }
}
