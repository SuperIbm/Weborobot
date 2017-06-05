<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 */
namespace App\Modules\Page\Providers;

use App;
use Route;
use Illuminate\Support\ServiceProvider;
use App\Modules\Page\Models\PageEloquent as Page;
use App\Modules\Page\Models\PageTreeArrayEloquent as PageTreeArray;
use App\Modules\Page\Repositories\PageEloquent;
use App\Modules\Page\Repositories\PageTreeArrayEloquent;
use App\Modules\Page\Events\Listeners\PageListener;
use App\Modules\Page\Models\PageCurrent;


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
    $this->_setRoutes();
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

        App::singleton('pageCurrent',
            function()
            {
                return new PageCurrent
                (
                App::make('App\Modules\Page\Repositories\Page'),
                App::make('App\Modules\PageTemplate\Repositories\PageTemplate')
                );
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
     * Установка маршрутов для структуры сайта.
     * @since 1.0
     * @version 1.0
     */
    protected function _setRoutes()
    {
    $data = App::make('App\Modules\Page\Repositories\PageTreeArray')->read(null, true);
    $tree = App::make('App\Modules\Page\Repositories\PageTreeArray')->tree($data);

        function setRoutes($tree)
        {
            if($tree)
            {
                for($i = 0; $i < count($tree); $i++)
                {
                    if($tree[$i]['modeAccess'] == 'Свободный')
                    {
                        Route::get($tree[$i]['path'], 'App\Modules\Page\Http\Controllers\PageController@read')
                        ->middleware('web');
                    }
                    else if($tree[$i]['modeAccess'] == 'Ограниченный')
                    {
                        Route::get($tree[$i]['path'], 'App\Modules\Page\Http\Controllers\PageController@read')
                        ->middleware
                        (
                            [
                            'auth.user:group,Пользователи',
                            'auth.user:page,'.$tree[$i]['idPage'],
                            'web'
                            ]
                        );
                    }

                    if(isset($tree[$i]['children'])) setRoutes($tree[$i]['children']);
                }
            }
        }

    setRoutes($tree);
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
