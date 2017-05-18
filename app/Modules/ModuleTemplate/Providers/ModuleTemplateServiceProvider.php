<?php
/**
 * Модуль Шаблоны модуля.
 * Этот модуль содержит все классы для работы с шаблонами модулей системы.
 * @package App.Modules.ModuleTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ModuleTemplate\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent as ModuleTemplate;
use App\Modules\ModuleTemplate\Events\Listeners\ModuleTemplateListener;
use App\Modules\ModuleTemplate\Repositories\ModuleTemplateEloquent;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleTemplateServiceProvider extends ServiceProvider
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
	    App::singleton('App\Modules\ModuleTemplate\Repositories\ModuleTemplate',
		    function()
		    {
            ModuleTemplate::observe(ModuleTemplateListener::class);
		    return new ModuleTemplateEloquent(new ModuleTemplate());
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
            __DIR__.'/../Config/config.php' => config_path('Moduletemplate.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'Moduletemplate'
        );
    }

	/**
	 * Регистрация представлений.
	 * @return void
	 */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/Moduletemplate');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/Moduletemplate';
        }, \Config::get('view.paths')), [$sourcePath]), 'Moduletemplate');
    }

	/**
	 * Регистрация локалей.
	 * @return void
	 */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/Moduletemplate');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'Moduletemplate');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'Moduletemplate');
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
