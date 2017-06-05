<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 * @package App.Modules.Access
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Access\Http\Middleware;

use Config;
use Closure;
use Illuminate\Http\Request;
use Gate;


/**
 * Класс посредник для проверки пользователя, что он является "Пользователи.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowOnlyUser
{
    /**
     * Проверка пользователя, что он является "Пользователи".
     * @param \Illuminate\Http\Request $Request Запрос.
     * @param \Closure $Next Функция последющего действия.
     * @param array|null $params Параметры доступа.
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $Request, Closure $Next, ...$params)
    {
        if(!Gate::allows('user'))
        {
            if($Request->ajax())
            {
                return response()->json
                (
                    [
                    'success' => false,
                    'errortype' => 'noAccess',
                    'errormsg' => 'Время доступа к этой части приложения было исчерпано, пройдите авторизацию повторно!'
                    ]
                );
            }
            else if(Config::get('auth.redirections.login')) return redirect(Config::get('auth.redirections.login'));
            else if(Config::get('auth.redirections.register')) return redirect(Config::get('auth.redirections.login'));
            else response('Unauthorized!', 401);
        }
        else
        {
            if(!empty($params))
            {
            $name = $params[0];
            array_shift($params);

                if(!Gate::allows($name, $params))
                {
                    if($Request->ajax())
                    {
                        return response()->json
                        (
                            [
                            'success' => false,
                            'errortype' => 'noAccess',
                            'errormsg' => 'Время доступа к этой части приложения было исчерпано, пройдите авторизацию повторно!'
                            ]
                        );
                    }
                    else if(Config::get('auth.redirections.login')) return redirect(Config::get('auth.redirections.login'));
                    else if(Config::get('auth.redirections.register')) return redirect(Config::get('auth.redirections.login'));
                    else return response('Unauthorized!', 401);
                }
            }
        }

    return $Next($Request);
    }
}
