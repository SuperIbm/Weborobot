<?php
/**
 * Модуль Компонента.
 * Этот модуль содержит все классы для работы с компонентами системы.
 * @package App.Modules.Component
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Component\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\Component\Models\ComponentEloquent as Component;
use App\Modules\Component\Events\Listeners\ComponentListener;
use App\Modules\Component\Repositories\ComponentEloquent;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ComponentServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\Component\Repositories\Component',
            function()
            {
            return new ComponentEloquent(new Component());
            }
        );

    Component::observe(ComponentListener::class);
    }

    /**
     * Регистрация настроек.
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('Component.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'Component'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/Component');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/Component';
        }, \Config::get('view.paths')), [$sourcePath]), 'Component');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/Component');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'Component');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'Component');
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
