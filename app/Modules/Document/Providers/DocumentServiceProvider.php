<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 * @package App.Modules.Document
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Document\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Document;

use App\Modules\Document\Models\DocumentEloquent as DocumentEloquentModel;
use App\Modules\Document\Repositories\DocumentEloquent;

use App\Modules\Document\Models\DocumentMongoDb as DocumentMongoDbModel;
use App\Modules\Document\Repositories\DocumentMongoDb;

use App\Modules\Document\Events\Listeners\DocumentListener;

use App\Modules\Document\Models\DocumentManager;

use App\Modules\Document\Models\DocumentDriverManager;
use App\Modules\Document\Models\DocumentDriverBase;
use App\Modules\Document\Models\DocumentDriverFtp;
use App\Modules\Document\Models\DocumentDriverHttp;
use App\Modules\Document\Models\DocumentDriverLocal;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentServiceProvider extends ServiceProvider
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
        App::singleton('document',
            function($App)
            {
            return new DocumentManager($App);
            }
        );

        Document::extend('database',
            function($app)
            {
                echo "database <br>";
            DocumentEloquentModel::observe(DocumentListener::class);
            return new DocumentEloquent(new DocumentEloquentModel());
            }
        );

        Document::extend('mongodb',
            function($app)
            {
            DocumentMongoDbModel::observe(DocumentListener::class);
            return new DocumentMongoDb(new DocumentMongoDbModel());
            }
        );

	    App::singleton('document.driver',
		    function($App)
		    {
		    return new DocumentDriverManager($App);
		    }
	    );

	    App::make('document.driver')->extend('base',
		    function()
		    {
		    return new DocumentDriverBase();
		    }
	    );

        App::make('document.driver')->extend('ftp',
            function()
            {
                return new DocumentDriverFtp();
            }
        );

	    App::make('document.driver')->extend('local',
		    function()
		    {
			    return new DocumentDriverLocal();
		    }
	    );

	    App::make('document.driver')->extend('http',
		    function()
		    {
			    return new DocumentDriverHttp();
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
            __DIR__.'/../Config/config.php' => config_path('document.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'document'
        );
    }

	/**
	 * Регистрация представлений.
	 * @return void
	 */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/document');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/document';
        }, \Config::get('view.paths')), [$sourcePath]), 'document');
    }

	/**
	 * Регистрация локалей.
	 * @return void
	 */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/document');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'document');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'document');
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
