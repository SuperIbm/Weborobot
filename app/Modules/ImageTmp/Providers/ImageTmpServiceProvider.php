<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\ImageTmp\Models\ImageTmpEloquent as ImageTmp;
use App\Modules\ImageTmp\Repositories\ImageTmpEloquent;
use App\Modules\ImageTmp\Events\Listeners\ImageTmpListener;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageTmpServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\ImageTmp\Repositories\ImageTmp',
            function()
            {
            ImageTmp::observe(ImageTmpListener::class);
            return new ImageTmpEloquent(new ImageTmp());
            }
        );

        App::singleton('imageTmp',
            function()
            {
            ImageTmp::observe(ImageTmpListener::class);
            return new ImageTmpEloquent(new ImageTmp());
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
            __DIR__.'/../Config/config.php' => config_path('imagetmp.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'imagetmp'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/imagetmp');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/imagetmp';
        }, \Config::get('view.paths')), [$sourcePath]), 'imagetmp');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/imagetmp');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'imagetmp');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'imagetmp');
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
