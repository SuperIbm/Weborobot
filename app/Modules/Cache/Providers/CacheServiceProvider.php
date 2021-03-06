<?php
/**
 * Модуль Кеширования.
 * Этот модуль содержит все классы для работы с кешированием.
 * @package App.Modules.Cache
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Cache\Providers;

use Illuminate\Support\ServiceProvider;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CacheServiceProvider extends ServiceProvider
{
/**
 * Индификатор отложенной загрузки.
 * @var bool
 * @version 1.0
 * @since 1.0
 */
protected $defer = false;

    /**
     * Обработчик события загрузки приложения.
     * @return void
     * @version 1.0
     * @since 1.0
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
     * @version 1.0
     * @since 1.0
     */
    public function register()
    {
        //
    }

    /**
     * Регистрация настроек.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('cache.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'cache'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/cache');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/cache';
        }, \Config::get('view.paths')), [$sourcePath]), 'cache');
    }

    /**
     * Регистрация локалей.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/cache');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'cache');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'cache');
        }
    }

    /**
     * Получение сервисов через сервис-провайдер.
     * @return array
     * @version 1.0
     * @since 1.0
     */
    public function provides()
    {
        return [];
    }
}
