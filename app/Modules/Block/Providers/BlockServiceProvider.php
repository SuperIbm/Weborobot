<?php
/**
 * Модуль Блоки страницы.
 * Этот модуль содержит все классы для работы с блокми страницы.
 * @package App.Modules.Block
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Block\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use App\Modules\Block\Models\Block;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class BlockServiceProvider extends ServiceProvider
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
        App::bind('block',
            function()
            {
                return new Block
                (
                App::make('App\Modules\Page\Repositories\Page'),
                App::make('App\Modules\PageTemplate\Repositories\PageTemplate'),
                App::make('App\Modules\PageComponent\Repositories\PageComponent'),
                App::make('App\Modules\PageComponentSetting\Repositories\PageComponentSetting'),
                App::make('App\Modules\Module\Repositories\Module')
                );
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
            __DIR__.'/../Config/config.php' => config_path('block.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'block'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/block');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/block';
        }, \Config::get('view.paths')), [$sourcePath]), 'block');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/block');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'block');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'block');
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
