<?php
/**
 * Модуль Разделы административной системы.
 * Этот модуль содержит все классы для работы с разделами административной системы.
 * @package App.Modules.AdminSection
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\AdminSection\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\AdminSection\Models\AdminSectionEloquent as AdminSection;
use App\Modules\AdminSection\Repositories\AdminSectionEloquent;

use App\Modules\AdminSection\Models\AdminSectionTreeArrayEloquent as AdminSectionTreeArray;
use App\Modules\AdminSection\Repositories\AdminSectionTreeArrayEloquent;

use App\Modules\AdminSection\Events\Listeners\AdminSectionListener;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AdminSectionServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\AdminSection\Repositories\AdminSection',
            function()
            {
            AdminSection::observe(AdminSectionListener::class);
            return new AdminSectionEloquent(new AdminSection());
            }
        );

        App::singleton('App\Modules\AdminSection\Repositories\AdminSectionTreeArray',
            function()
            {
            AdminSectionTreeArray::observe(AdminSectionListener::class);
            return new AdminSectionTreeArrayEloquent(new AdminSectionTreeArray());
            }
        );
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
            __DIR__.'/../Config/config.php' => config_path('adminsection.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'adminsection'
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
        $viewPath = base_path('resources/views/modules/adminsection');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminsection';
        }, \Config::get('view.paths')), [$sourcePath]), 'adminsection');
    }

	/**
	 * Регистрация локалей.
	 * @return void
	 * @since 1.0
 	 * @version 1.0
	 */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/adminsection');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminsection');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'adminsection');
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
