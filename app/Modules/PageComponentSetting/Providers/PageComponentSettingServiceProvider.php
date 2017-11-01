<?php
/**
 * Модуль Настройки компонента страницы.
 * Этот модуль содержит все классы для работы настройками компонента на странице.
 * @package App.Modules.PageComponentSetting
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponentSetting\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent as PageComponentSetting;
use App\Modules\PageComponentSetting\Repositories\PageComponentSettingEloquent;
use App\Modules\PageComponentSetting\Events\Listeners\PageComponentSettingListener;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageComponentSettingServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\PageComponentSetting\Repositories\PageComponentSetting',
            function()
            {
            return new PageComponentSettingEloquent(new PageComponentSetting());
            }
        );

    PageComponentSetting::observe(PageComponentSettingListener::class);
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
            __DIR__.'/../Config/config.php' => config_path('pagecomponentsetting.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'pagecomponentsetting'
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
        $viewPath = base_path('resources/views/modules/pagecomponentsetting');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/pagecomponentsetting';
        }, \Config::get('view.paths')), [$sourcePath]), 'pagecomponentsetting');
    }

    /**
     * Регистрация локалей.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/pagecomponentsetting');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'pagecomponentsetting');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'pagecomponentsetting');
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
