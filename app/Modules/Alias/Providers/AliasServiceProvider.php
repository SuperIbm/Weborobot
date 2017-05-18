<?php
/**
 * Модуль Псевдонимы.
 * Этот модуль содержит все классы для работы с псевдонимами.
 * @package App.Modules.Alias
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Alias\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use App\Modules\Alias\Models\AliasEloquent as Alias;
use App\Modules\Alias\Repositories\AliasEloquent;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AliasServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\Alias\Repositories\Alias',
            function()
            {
            return new AliasEloquent(new Alias());
            }
        );
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
            __DIR__.'/../Config/config.php' => config_path('alias.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'alias'
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
        $viewPath = base_path('resources/views/modules/alias');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/alias';
        }, \Config::get('view.paths')), [$sourcePath]), 'alias');
    }

    /**
     * Регистрация локалей.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/alias');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'alias');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'alias');
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
