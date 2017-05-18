<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Http\Middleware;

use Closure;
use Action;
use Path;
use Illuminate\Http\Request;
use App\Modules\Seo\Jobs\Seo as SeoJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Класс посредник для запуска системы учета статистики.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Seo
{
use DispatchesJobs;
    
    /**
     * Обработка входящего запроса.
     * @param \Illuminate\Http\Request Запрос.
     * @param \Closure $Next Функция последющего действия.
     * @param string|null $guard Значение доступа.
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $Request, Closure $Next, $guard = null)
    {
    $Result = $Next($Request);

        if($Request->input("scan", 0) == 0 && Path::isBot() == false)
        {
        $actionShows = Action::status("Seo_shows", 1, 1 / 60 * 15);
        $actionVisitis = Action::status("Seo_visits", 1, 30);
        $actionVisitors = Action::status("Seo_visitors", 1, 60 * 24);
        $actionVisitorsNew = Action::status("Seo_visitorsNew", 1, 60 * 24);

            if($actionShows == true) Action::add("Seo_shows");
            if($actionVisitis == true) Action::add("Seo_visits");
            if($actionVisitors == true) Action::add("Seo_visitors");
            if($actionVisitorsNew == true) Action::add("Seo_visitorsNew");

        $this->dispatch(new SeoJob($actionShows, $actionVisitis, $actionVisitors, $actionVisitorsNew));
        }

    return $Result;
    }
}
