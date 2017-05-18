<?php
/**
 * Модуль Логирование.
 * Этот модуль содержит все классы для работы с логированием.
 * @package App.Modules.Log
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Log\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogServiceProvider extends ServiceProvider
{
    /**
     * Индификатор отложенной загрузки.
     * @var bool
     */
    protected $defer = false;

    /**
     * Регистрация сервис провайдеров.
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
    }

    /**
     * Регистрация настроек.
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Регистрация настроек.
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('log.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'log'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/log');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/log';
        }, \Config::get('view.paths')), [$sourcePath]), 'log');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/log');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'log');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'log');
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
