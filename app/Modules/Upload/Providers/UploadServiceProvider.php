<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\Upload\Models\UploadEloquent as Upload;
use App\Modules\Upload\Repositories\UploadEloquent;

use App\Modules\Upload\Models\UploadSourceEloquent as UploadSource;
use App\Modules\Upload\Repositories\UploadSourceEloquent;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\Upload\Repositories\Upload',
            function($App)
            {
                return new UploadEloquent
                (
                    new Upload(),
                    $App->make('App\Modules\Module\Repositories\Module'),
                    $App->make('App\Modules\AdminSection\Repositories\AdminSectionTreeArray'),
                    $App->make('App\Modules\Component\Repositories\Component'),
                    $App->make('App\Modules\ModuleTemplate\Repositories\ModuleTemplate'),
                    $App->make('App\Modules\Widget\Repositories\Widget')
                );
            }
        );

        App::singleton('App\Modules\Upload\Repositories\UploadSource',
            function()
            {
            return new UploadSourceEloquent(new UploadSource());
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
            __DIR__.'/../Config/config.php' => config_path('upload.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'upload'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/upload');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/upload';
        }, \Config::get('view.paths')), [$sourcePath]), 'upload');
    }

    /**
     * Регистрация локалей.
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/upload');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'upload');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'upload');
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
