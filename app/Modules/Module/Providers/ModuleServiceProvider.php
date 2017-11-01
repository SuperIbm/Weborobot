<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\Module\Models\ModuleEloquent as Module;
use App\Modules\Module\Events\Listeners\ModuleListener;
use App\Modules\Module\Repositories\ModuleEloquent;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\Module\Repositories\Module',
            function($App)
            {
                return new ModuleEloquent
                (
                new Module(),
                $App->make('App\Modules\AdminSection\Repositories\AdminSectionTreeArray'),
                $App->make('App\Modules\Component\Repositories\Component'),
                $App->make('App\Modules\ModuleTemplate\Repositories\ModuleTemplate'),
                $App->make('App\Modules\Widget\Repositories\Widget'),
                $App->make('App\Modules\User\Repositories\UserRoleAdminSection')
                );
            }
        );

    Module::observe(ModuleListener::class);
    }

	/**
	 * Регистрация настроек.
	 * @return void
	 */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('Module.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'Module'
        );
    }

	/**
	 * Регистрация представлений.
	 * @return void
	 */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/Module');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/Module';
        }, \Config::get('view.paths')), [$sourcePath]), 'Module');
    }

	/**
	 * Регистрация локалей.
	 * @return void
	 */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/Module');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'Module');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'Module');
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
