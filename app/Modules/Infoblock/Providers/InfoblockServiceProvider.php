<?php
/**
 * Модуль Инфоблоков.
 * Этот модуль содержит все классы для работы с инфоблоками.
 * @package App.Modules.Infoblock
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Infoblock\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\Infoblock\Models\InfoblockEloquent as Infoblock;
use App\Modules\Infoblock\Repositories\InfoblockEloquent;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InfoblockServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\Infoblock\Repositories\Infoblock',
            function()
            {
            return new InfoblockEloquent(new Infoblock());
            }
        );
    }

    /**
     * Регистрация настроек.
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('infoblock.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'infoblock'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/infoblock');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/infoblock';
        }, \Config::get('view.paths')), [$sourcePath]), 'infoblock');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/infoblock');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'infoblock');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'infoblock');
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
