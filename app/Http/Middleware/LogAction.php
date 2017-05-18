<?php
/**
 * Основные посредники.
 * @package App.Http.Middleware
 * @version 1.0
 * @since 1.0
 */
namespace App\Http\Middleware;

use Closure;
use Log;
use Illuminate\Http\Request;

/**
 * Класс посредник для записей медленных действий.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogAction
{
    /**
     * Запись в лог всех медленных действий.
     * @param \Illuminate\Http\Request $Request Запрос.
     * @param \Closure $Next Функция последющего действия.
     * @param string|null $guard Значение доступа.
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $Request, Closure $Next, $guard = null)
    {
        if(function_exists('getrusage')) $usage = getrusage();

    $executeTimeStart = microtime(true);
    $executeMemoryStart = memory_get_usage();

        if(function_exists('getrusage')) $executeCpuStart = $usage["ru_utime.tv_sec"] * 1e6 + $usage["ru_utime.tv_usec"];

    $Response = $Next($Request);

        if(function_exists('getrusage')) $usage = getrusage();

    $executeTimeEnd = microtime(true);
    $executeMemoryEnd = memory_get_usage();

        if(function_exists('getrusage')) $executeCpuEnd = $usage["ru_utime.tv_sec"] * 1e6 + $usage["ru_utime.tv_usec"];

    $executeTime = $executeTimeEnd - $executeTimeStart;
    $executeMemory = $executeMemoryEnd - $executeMemoryStart;

        if(function_exists('getrusage'))
        {
        $executeCpu = $executeCpuEnd - $executeCpuStart;
        $cpu = ($executeCpu / ($executeTime * 1000000) * 100);
        }
        else $cpu = 0;

    $executeMemory = $executeMemory / 1048576;

        if
        (
            config('app.log_slowTime', 0) == 0 ||
            config('app.log_slowMemory', 0) == 0 ||
            config('app.log_slowCpu', 0) == 0 ||
            $executeTime > config('app.log_slowTime') ||
            $executeMemory > config('app.log_slowMemory') ||
            $cpu > config('app.log_slowCpu')
        )
        {
            Log::info($Request->fullUrl(),
                [
                "time" => $executeTime,
                "memory" => $executeMemory,
                "cpu" => $cpu,
                "type" => "execute"
                ]
            );
        }

    return $Response;
    }
}
