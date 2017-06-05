<?php
/**
 * Модуль Наследование компонентов.
 * Этот модуль содержит все классы для работы с наследованием компонентов.
 * @package App.Modules.Inherit
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Inherit\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InheritServiceProvider extends ServiceProvider
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
        //
    }

    /**
     * Регистрация настроек.
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('inherit.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'inherit'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/inherit');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/inherit';
        }, \Config::get('view.paths')), [$sourcePath]), 'inherit');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/inherit');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'inherit');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'inherit');
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
