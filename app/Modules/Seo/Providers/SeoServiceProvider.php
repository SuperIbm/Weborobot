<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\Seo\Models\SeoEloquent as SeoEloquentModel;
use App\Modules\Seo\Repositories\SeoEloquent;
use App\Modules\Seo\Models\SeoMongoDb as SeoMongoDbModel;
use App\Modules\Seo\Repositories\SeoMongoDb;
use App\Modules\Seo\Models\SeoManager;
use Seo;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SeoServiceProvider extends ServiceProvider
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
        App::singleton('seo',
            function($App)
            {
            return new SeoManager($App);
            }
        );

        Seo::extend('database',
            function($app)
            {
            return new SeoEloquent(new SeoEloquentModel());
            }
        );

        Seo::extend('mongodb',
            function($app)
            {
            return new SeoMongoDb(new SeoMongoDbModel());
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
            __DIR__.'/../Config/config.php' => config_path('seo.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'seo'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/seo');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/seo';
        }, \Config::get('view.paths')), [$sourcePath]), 'seo');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/seo');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'seo');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'seo');
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
