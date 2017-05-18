<?php
/**
 * Модуль Компонента страницы.
 * Этот модуль содержит все классы для работы с компонентами страницы.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponent\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use App\Modules\PageComponent\Models\PageComponentEloquent as PageComponent;
use App\Modules\PageComponent\Models\PageComponentTreeArrayEloquent as PageComponentTreeArray;
use App\Modules\PageComponent\Repositories\PageComponentEloquent;
use App\Modules\PageComponent\Repositories\PageComponentTreeArrayEloquent;
use App\Modules\PageComponent\Events\Listeners\PageComponentListener;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageComponentServiceProvider extends ServiceProvider
{
/**
 * Индификатор отложенной загрузки.
 * @var bool
 * @since 1.0
 * @version 1.0
 */
protected $defer = false;

    /**
     * Обработчик события загрузки приложения.
     * @return void
     * @since 1.0
     * @version 1.0
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
     * @since 1.0
     * @version 1.0
     */
    public function register()
    {
        App::singleton('App\Modules\PageComponent\Repositories\PageComponent',
            function()
            {
            PageComponent::observe(PageComponentListener::class);
            return new PageComponentEloquent(new PageComponent());
            }
        );

        App::singleton('App\Modules\PageComponent\Repositories\PageComponentTreeArray',
            function()
            {
            PageComponentTreeArray::observe(PageComponentListener::class);
            return new PageComponentTreeArrayEloquent(new PageComponentTreeArray());
            }
        );
    }

    /**
     * Регистрация настроек.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('pagecomponent.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'pagecomponent'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/pagecomponent');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/pagecomponent';
        }, \Config::get('view.paths')), [$sourcePath]), 'pagecomponent');
    }

    /**
     * Регистрация локалей.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/pagecomponent');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'pagecomponent');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'pagecomponent');
        }
    }

    /**
     * Получение сервисов через сервис-провайдер.
     * @return array
     * @since 1.0
     * @version 1.0
     */
    public function provides()
    {
        return [];
    }
}
