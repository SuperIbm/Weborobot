<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CoreServiceProvider extends ServiceProvider
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

    }

	/**
	 * Регистрация настроек.
	 * @return void
	 */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('core.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'core'
        );
    }

	/**
	 * Регистрация представлений.
	 * @return void
	 */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/core');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/core';
        }, \Config::get('view.paths')), [$sourcePath]), 'core');
    }

	/**
	 * Регистрация локалей.
	 * @return void
	 */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'core');
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
