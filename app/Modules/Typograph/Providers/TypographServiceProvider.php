<?php
/**
 * Модуль Типографи.
 * Этот модуль содержит все классы для работы с типографом.
 * @package App.Modules.Typograph
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Typograph\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class TypographServiceProvider extends ServiceProvider
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
        //
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
            __DIR__.'/../Config/config.php' => config_path('typograph.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'typograph'
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
        $viewPath = base_path('resources/views/modules/typograph');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/typograph';
        }, \Config::get('view.paths')), [$sourcePath]), 'typograph');
    }

    /**
     * Регистрация локалей.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/typograph');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'typograph');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'typograph');
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
