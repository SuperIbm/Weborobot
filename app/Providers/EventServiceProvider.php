<?php
/**
 * Основные провайдеры.
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use DB;
use Log;
use Event;

/**
 * Класс сервис-провайдера для событий.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * Список событий для приложения.
     * @var array
     */
    protected $listen =
    [
	    // Регистрация пользователя
	    'Illuminate\Auth\Events\Registered' =>
	    [
	    'App\Modules\Access\Events\Listeners\LogRegisteredUser',
	    ],

	    // Попытка аунтификации пользователя
	    'Illuminate\Auth\Events\Attempting' =>
	    [
	    'App\Modules\Access\Events\Listeners\LogAuthenticationAttempt',
	    ],

	    // Удачная аунтификация
	    'Illuminate\Auth\Events\Login' =>
	    [
	    'App\Modules\Access\Events\Listeners\LogSuccessfulLogin',
	    ],

	    // Удачный выход
	    'Illuminate\Auth\Events\Logout' =>
	    [
	    'App\Modules\Access\Events\Listeners\LogSuccessfulLogout',
	    ],

	    // Блокировка
	    'Illuminate\Auth\Events\Lockout' =>
	    [
	    'App\Modules\Access\Events\Listeners\LogLockout',
	    ],
    ];


    /**
     * Обработчик события загрузки приложения.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot()
    {
    parent::boot();

        if(config('database.log', false))
        {
            DB::listen
            (
                function($Query)
                {
                    if(($Query->time / 1000) >= config('database.timeSlow', 0))
                    {
                        $data =
                        [
                        "bindings" => $Query->bindings,
                        "time" => $Query->time / 1000,
                        "sql" => $Query->sql,
                        ];

                        foreach($Query->bindings as $i => $binding)
                        {
                            if($binding instanceof \DateTime) $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                            else if(is_string($binding)) $bindings[$i] = "'$binding'";
                        }

                    $query = str_replace(array('%', '?'), array('%%', '%s'), $Query->sql);
                    $query = vsprintf($query, $Query->bindings);

                    $data["type"] = "base";

                        if(config('database.timeSlow', 0) != 0) Log::warning($query, $data);
                        else Log::info($query, $data);
                    }
                }
            );
        }
    }
}
