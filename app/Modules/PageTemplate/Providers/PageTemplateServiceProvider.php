<?php
/**
 * Модуль Шаблоны для страниц.
 * Этот модуль содержит все классы для работы с шаблонами для страниц.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageTemplate\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\PageTemplate\Models\PageTemplateEloquent as PageTemplate;
use App\Modules\PageTemplate\Repositories\PageTemplateEloquent;
use App\Modules\PageTemplate\Events\Listeners\PageTemplateListener;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageTemplateServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\PageTemplate\Repositories\PageTemplate',
            function($App)
            {
                return new PageTemplateEloquent
                (
                new PageTemplate(),
                $App->make('App\Modules\Page\Repositories\Page'),
                $App->make('App\Modules\PageComponent\Repositories\PageComponent')
                );
            }
        );

    PageTemplate::observe(PageTemplateListener::class);
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
            __DIR__.'/../Config/config.php' => config_path('pagetemplate.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'pagetemplate'
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
        $viewPath = base_path('resources/views/modules/pagetemplate');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/pagetemplate';
        }, \Config::get('view.paths')), [$sourcePath]), 'pagetemplate');
    }

    /**
     * Регистрация локалей.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/pagetemplate');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'pagetemplate');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'pagetemplate');
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
