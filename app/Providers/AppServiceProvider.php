<?php
/**
 * Основные провайдеры.
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use Config;
use DB;
use App;
use Log;
use App\Models\Actioner;
use App\Models\Utiler;
use App\Models\Pather;
use App\Models\CarbonLocalized;
use App\Models\Smarty\SmartyComponentEngine;
use App\Models\FileComponentViewFinder;

use App\Models\Logs\LogWriterManager;
use App\Models\Logs\LogWriterDatabase;
use App\Models\Logs\LogWriterMongoDb;

use App\Models\Logs\LogReaderManager;
use App\Models\Logs\LogReaderDatabase;
use App\Models\Logs\LogReaderFile;

use Illuminate\Support\Facades\Validator;
use MongoDB\BSON\UTCDateTime;
use Chee\Pclzip\Pclzip;


/**
 * Класс сервис-провайдера для всего приложения.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Обработчик события загрузки приложения.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot()
    {
        Validator::extend('dateMongo',
            function($attribute, $value, $parameters, $validator)
            {
                if($value instanceof UTCDateTime) return true;
                else return false;
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
        // Записиь логов
        App::singleton('log.driver.writer',
            function($App)
            {
            return new LogWriterManager($App);
            }
        );

	    App::make('log.driver.writer')->extend('database',
		    function()
		    {
		    return new LogWriterDatabase(DB::connection(), config("app.log_table"), \Monolog\Logger::DEBUG);
		    }
	    );

	    App::make('log.driver.writer')->extend('mongodb',
		    function()
		    {
		    return new LogWriterMongoDb(DB::connection('mongodb'), config("app.log_table"), \Monolog\Logger::DEBUG);
		    }
	    );


	    // Чтение логов
        App::singleton('log.driver.reader',
            function($App)
            {
            return new LogReaderManager($App);
            }
        );

        App::make('log.driver.reader')->extend('database',
            function()
            {
            return new LogReaderDatabase(DB::connection(), config("app.log_table"), \Monolog\Logger::DEBUG);
            }
        );

        App::make('log.driver.reader')->extend('mongodb',
            function()
            {
            return new LogReaderDatabase(DB::connection('mongodb'), config("app.log_table"), \Monolog\Logger::DEBUG);
            }
        );

        App::make('log.driver.reader')->extend('file',
            function()
            {
            return new LogReaderFile(DB::connection('mongodb'), config("app.log_table"), \Monolog\Logger::DEBUG);
            }
        );

        if(Config::get("app.log_driver") != 'file')
        {
            Log::getMonolog()
            ->setHandlers
            (
                [
                App::make('log.driver.writer')
                ->driver(Config::get("app.log_driver"))
                ]
            );
        }

        App::singleton('log-reader',
            function()
            {
            return App::make('log.driver.reader')->driver(Config::get("app.log_driver"));
            }
        );

        App::bind('action', function()
            {
            return new Actioner();
            }
        );

        App::bind('path', function()
            {
            return new Pather();
            }
        );

        App::bind('util', function()
            {
            return new Utiler();
            }
        );

        App::singleton('zip', function()
            {
            return new Pclzip("");
            }
        );

        App::bind('carbon',
            function()
            {
            return new CarbonLocalized();
            }
        );

	    $this->app['view']->addExtension('tpldb', 'smartyComponent',
		    function()
	        {
		    return new SmartyComponentEngine($this->app['config']);
	        }
	    );

    $paths = Config::get('view.paths');
    View::setFinder(new FileComponentViewFinder($this->app['files'], $paths));
    }
}
