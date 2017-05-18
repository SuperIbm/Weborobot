<?php
/**
 * Основные посредники.
 * @package App.Http.Middleware
 * @version 1.0
 * @since 1.0
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Класс посредник для установки локалей.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Locale
{
    /**
     * Установка локалей.
     * @param \Illuminate\Http\Request $Request Запрос.
     * @param \Closure $Next Функция последющего действия.
     * @param string|null $guard Значение доступа.
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $Request, Closure $Next, $guard = null)
    {
    setlocale(LC_ALL, ['ru_RU.utf8', 'rus_RUS.utf8', 'russian']);
    setlocale(LC_NUMERIC, ['en_US.utf8']);

    return $Next($Request);
    }
}
