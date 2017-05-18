<?php
/**
 * Основные провайдеры.
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */
namespace app\Providers;

use App;
use Geo;
use Illuminate\Support\ServiceProvider;
use App\Models\Geo\GeoManager;
use App\Models\Geo\GeoBase;


/**
 * Класс сервис-провайдера для геокодирования.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeoServiceProvider extends ServiceProvider
{
    /**
     * Обработчик события загрузки приложения.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function boot()
	{
		App::singleton('geo',
			function($App)
			{
			return new GeoManager($App);
			}
		);

		Geo::extend('base',
			function($App)
			{
			return new GeoBase();
			}
		);
	}

    /**
     * Регистрация сервис провайдеров.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function register()
	{
		//
	}
}