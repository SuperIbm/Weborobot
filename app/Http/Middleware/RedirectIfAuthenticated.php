<?php
/**
 * Основные посредники.
 * @package App.Http.Middleware
 * @version 1.0
 * @since 1.0
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Класс посредник для установки перехвата не авторизованных пользователей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class RedirectIfAuthenticated
{
    /**
     * Перехватчик не авторизованных пользователей.
     * @param \Illuminate\Http\Request $Request Запрос.
     * @param \Closure $Next Функция последющего действия.
     * @param string|null $guard Значение доступа.
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $Request, Closure $Next, $guard = null)
    {
        if(Auth::guard($guard)->check()) return redirect('/');

    return $Next($Request);
    }
}
