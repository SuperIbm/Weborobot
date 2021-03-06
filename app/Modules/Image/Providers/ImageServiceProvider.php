<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Image;

use App\Modules\Image\Models\ImageEloquent as ImageEloquentModel;
use App\Modules\Image\Repositories\ImageEloquent;

use App\Modules\Image\Models\ImageMongoDb as ImageMongoDbModel;
use App\Modules\Image\Repositories\ImageMongoDb;

use App\Modules\Image\Events\Listeners\ImageListener;

use App\Modules\Image\Models\ImageManager;

use App\Modules\Image\Models\ImageDriverManager;
use App\Modules\Image\Models\ImageDriverBase;
use App\Modules\Image\Models\ImageDriverFtp;
use App\Modules\Image\Models\ImageDriverHttp;
use App\Modules\Image\Models\ImageDriverLocal;

use ImageFilter;
use App\Modules\Image\Models\ImageFilterManager;
use App\Modules\Image\Filters\ImageFilterChopedSize;
use App\Modules\Image\Filters\ImageFilterWatermark;
use App\Modules\Image\Filters\ImageFilterFixedSize;
use App\Modules\Image\Filters\ImageFilterGrey;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageServiceProvider extends ServiceProvider
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
        App::singleton('image',
            function($App)
            {
            return new ImageManager($App);
            }
        );

        Image::extend('database',
            function()
            {
            ImageEloquentModel::observe(ImageListener::class);
            return new ImageEloquent(new ImageEloquentModel());
            }
        );

        Image::extend('mongodb',
            function()
            {
            ImageMongoDbModel::observe(ImageListener::class);
            return new ImageMongoDb(new ImageMongoDbModel());
            }
        );

	    App::singleton('image.driver',
		    function($App)
		    {
		    return new ImageDriverManager($App);
		    }
	    );

	    App::make('image.driver')->extend('base',
		    function()
		    {
		    return new ImageDriverBase();
		    }
	    );

        App::make('image.driver')->extend('ftp',
            function()
            {
                return new ImageDriverFtp();
            }
        );

	    App::make('image.driver')->extend('local',
		    function()
		    {
			    return new ImageDriverLocal();
		    }
	    );

	    App::make('image.driver')->extend('http',
		    function()
		    {
			    return new ImageDriverHttp();
		    }
	    );

	    App::bind('image.filter',
		    function($App)
		    {
			    return new ImageFilterManager($App);
		    }
	    );

	    ImageFilter::extend('chopedSize',
		    function()
		    {
		    return new ImageFilterChopedSize();
		    }
	    );

	    ImageFilter::extend('watermark',
		    function()
		    {
			    return new ImageFilterWatermark();
		    }
	    );

	    ImageFilter::extend('fixedSize',
		    function()
		    {
			    return new ImageFilterFixedSize();
		    }
	    );

	    ImageFilter::extend('grey',
		    function()
		    {
		    return new ImageFilterGrey();
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
            __DIR__.'/../Config/config.php' => config_path('image.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'image'
        );
    }

	/**
	 * Регистрация представлений.
	 * @return void
	 */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/image');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/image';
        }, \Config::get('view.paths')), [$sourcePath]), 'image');
    }

	/**
	 * Регистрация локалей.
	 * @return void
	 */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/image');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'image');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'image');
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
