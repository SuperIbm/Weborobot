<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 */
namespace App\Modules\Page\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use App\Modules\Page\Models\PageEloquent as Page;
use App\Modules\Page\Models\PageTreeArrayEloquent as PageTreeArray;
use App\Modules\Page\Repositories\PageEloquent;
use App\Modules\Page\Repositories\PageTreeArrayEloquent;
use App\Modules\Page\Events\Listeners\PageListener;



/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageServiceProvider extends ServiceProvider
{
/**
 * Индификатор отложенной загрузки.
 * @var bool
 */
protected $defer = false;

	/**
	 * Обработчик события загрузки приложения.
	 * @return void
	 */
    public function boot()
    {
    $this->registerTranslations();
    $this->registerConfig();
    $this->registerViews();
    }

	/**
	 * Регистрация сервис провайдеров.
	 * @return void
	 */
    public function register()
    {
        App::singleton('page',
            function()
            {
            return new PageEloquent(new Page());
            }
        );

        App::singleton('App\Modules\Page\Repositories\Page',
	        function()
	        {
            Page::observe(PageListener::class);  
	        return new PageEloquent(new Page());
	        }
        );

        App::singleton('App\Modules\Page\Repositories\PageTreeArray',
            function()
            {
            PageTreeArray::observe(PageListener::class);
            return new PageTreeArrayEloquent(new PageTreeArray());
            }
        );
    }

	/**
	 * Регистрация настроек.
	 * @return void
	 */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('page.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'page'
        );
    }

	/**
	 * Регистрация представлений.
	 * @return void
	 */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/page');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/page';
        }, \Config::get('view.paths')), [$sourcePath]), 'page');
    }

	/**
	 * Регистрация локалей.
	 * @return void
	 */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/page');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'page');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'page');
        }
    }

	/**
	 * Получение сервисов через сервис-провайдер.
	 * @return array
	 */
    public function provides()
    {
        return [];
    }
}
