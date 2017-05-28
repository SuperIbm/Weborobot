<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Статус установленной системы
    |--------------------------------------------------------------------------
    |
    | Определяем установлена ли система или нет.
    */
    'installed' => env('APP_INSTALLED', true),

    /*
    |--------------------------------------------------------------------------
    | Версия системы
    |--------------------------------------------------------------------------
    |
    | Текущая версия системы.
    */
    'version' => '1.0',

    /*
    |--------------------------------------------------------------------------
    | Сайт на реконструкции
    |--------------------------------------------------------------------------
    |
    | Здесь можно определить находиться ли сайт на реконструкции.
    */

    'siteReconstruction' => env('APP_SITE_RECONSTRUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Название приложения
    |--------------------------------------------------------------------------
    |
    | Здесь можно определить как называется приложение, используется так же
    | для названия самого сайта.
    */

    'name' => env('APP_NAME', 'Weborobot'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost/'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'Europe/Moscow'),


    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => env('APP_LOCALE', 'ru'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',


    /*
    |--------------------------------------------------------------------------
    | Драйвер для хранения лога
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете определить, какой драйвер использовать для хранения логированных
    | данных. Это может быть "database" - база данных, "mongodb" - MongoDb, "file" - в файле
    |
    */
    'log_driver' => env('APP_LOG_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => env('APP_LOG', 'single'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    'log_table' => "log",

    /*
    |--------------------------------------------------------------------------
    | Определяем время после которого запрос считается медленным
    |--------------------------------------------------------------------------
    |
    | Вы можете установить в этом параметре количество секунд, после которых считается, что запрос
    | на выполнение программы был медленным, и значит, только этот запрос будут записаны в лог. Если параметр
    | установлен в 0, то все запросы попадут в лог, в независимости от их скорости
    | исполнения. Не советуем ставить это параметр в значение 0, т.к. лог файлы
    | через незначительное время будут переполнены логами.
    |
    */

    "log_slowTime" => 2,


    /*
    |--------------------------------------------------------------------------
    | Определяем память после которого запрос считается медленным
    |--------------------------------------------------------------------------
    |
    | Вы можете установить в этом параметре количество мегабайт, после которых считается, что запрос
    | на выполнение программы был медленным, и значит, только этот запрос будут записаны в лог. Если параметр
    | установлен в 0, то все запросы попадут в лог, в независимости от их скорости
    | исполнения. Не советуем ставить это параметр в значение 0, т.к. лог файлы
    | через незначительное время будут переполнены логами.
    |
    */

    "log_slowMemory" => 10,


    /*
    |--------------------------------------------------------------------------
    | Определяем нагрузку на ЦПУ после которого запрос считается медленным
    |--------------------------------------------------------------------------
    |
    | Вы можете установить в этом параметре процент нагрузки на ЦПУ, после которых считается, что запрос
    | на выполнение программы был медленным, и значит, только этот запрос будут записаны в лог. Если параметр
    | установлен в 0, то все запросы попадут в лог, в независимости от их скорости
    | исполнения. Не советуем ставить это параметр в значение 0, т.к. лог файлы
    | через незначительное время будут переполнены логами.
    |
    */

    "log_slowCpu" => 50,


    /*
    |--------------------------------------------------------------------------
    | Путь к основному CSS файлу шаблона
    |--------------------------------------------------------------------------
    |
    | Вы можете определить путь к основному CSS файлу шаблона. Он преднозначен для
    | CKEDITOR, который используется в административной системе. Это позволит отображать все стили,
    | которые использованы на сайте в редакторе.
    |
    */

    "css" => env('APP_CSS', 'css/main.css'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Jenssegers\Mongodb\MongodbServiceProvider::class,
        Nwidart\Modules\LaravelModulesServiceProvider::class,
        Way\Generators\GeneratorsServiceProvider::class,
        Jackiedo\LogReader\LogReaderServiceProvider::class,

        /*
         * Dev Service Providers...
         */
        Orangehill\Iseed\IseedServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class,
        Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Yangqi\Htmldom\HtmldomServiceProvider::class,
        App\Providers\SessionServiceProvider::class,
        App\Providers\CacheServiceProvider::class,
        Latrell\Smarty\SmartyServiceProvider::class,
        App\Providers\CurrencyServiceProvider::class,
        Tttptd\Mdash\MdashServiceProvider::class,
        App\Providers\SmsServiceProvider::class,
        App\Providers\GeoServiceProvider::class

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [
        'App' => Illuminate\Support\Facades\App::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

        // Advanced classes
        'MongoDb' => Jenssegers\Mongodb\Eloquent\Model::class,
        'Module' => Nwidart\Modules\Facades\Module::class,
        'Carbon' => App\Models\Facades\Carbon::class,
        'LogReader' => Jackiedo\LogReader\Facades\LogReader::class,
        'Mdash' => Tttptd\Mdash\Facades\Mdash::class,

        // Own classes
        'Installer' => App\Modules\Core\Facades\Installer::class,
        'Util' => App\Models\Facades\Util::class,
        'Zip' => App\Models\Facades\Zip::class,
        'Path' => App\Models\Facades\Path::class,
        'Action' => App\Models\Facades\Action::class,
        'Currency' => App\Models\Facades\Currency::class,
        'Sms' => App\Models\Facades\Sms::class,
        'Geo' => App\Models\Facades\Geo::class,
        'Captcha' => App\Modules\Captcha\Facades\Captcha::class,
        'Page' => App\Modules\Page\Facades\Page::class,
        'Image' => App\Modules\Image\Facades\Image::class,
        'ImageTmp' => App\Modules\ImageTmp\Facades\ImageTmp::class,
        'ImageFilter' => App\Modules\Image\Facades\ImageFilter::class,
        'Document' => App\Modules\Document\Facades\Document::class,
        'Seo' => App\Modules\Seo\Facades\Seo::class,

    ],

];
