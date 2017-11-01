<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\Publication\Models\PublicationEloquent as Publication;
use App\Modules\Publication\Repositories\PublicationEloquent;
use App\Modules\Publication\Events\Listeners\PublicationListener;

use App\Modules\Publication\Models\PublicationQueryWordEloquent as PublicationQueryWord;
use App\Modules\Publication\Repositories\PublicationQueryWordEloquent;

use App\Modules\Publication\Models\PublicationSectionEloquent as PublicationSection;
use App\Modules\Publication\Repositories\PublicationSectionEloquent;
use App\Modules\Publication\Events\Listeners\PublicationSectionListener;

use App\Modules\Publication\Models\PublicationSectionTreeArrayEloquent as PublicationSectionTreeArray;
use App\Modules\Publication\Repositories\PublicationSectionTreeArrayEloquent;

use App\Modules\Publication\Models\PublicationCommentEloquent as PublicationComment;
use App\Modules\Publication\Repositories\PublicationCommentEloquent;
use App\Modules\Publication\Events\Listeners\PublicationCommentListener;

use App\Modules\Publication\Models\PublicationCommentTreeArrayEloquent as PublicationCommentTreeArray;
use App\Modules\Publication\Repositories\PublicationCommentTreeArrayEloquent;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationServiceProvider extends ServiceProvider
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
        App::singleton('App\Modules\Publication\Repositories\Publication',
            function()
            {
            return new PublicationEloquent(new Publication());
            }
        );

    Publication::observe(PublicationListener::class);

        App::singleton('App\Modules\Publication\Repositories\PublicationQueryWord',
            function()
            {
            return new PublicationQueryWordEloquent(new PublicationQueryWord());
            }
        );

        App::singleton('App\Modules\Publication\Repositories\PublicationSection',
            function()
            {
            return new PublicationSectionEloquent(new PublicationSection());
            }
        );

    PublicationSection::observe(PublicationSectionListener::class);

        App::singleton('App\Modules\Publication\Repositories\PublicationSectionTreeArray',
            function()
            {
            return new PublicationSectionTreeArrayEloquent(new PublicationSectionTreeArray());
            }
        );

    PublicationSectionTreeArray::observe(PublicationSectionListener::class);

        App::singleton('App\Modules\Publication\Repositories\PublicationComment',
            function()
            {
            return new PublicationCommentEloquent(new PublicationComment());
            }
        );

    PublicationComment::observe(PublicationCommentListener::class);

        App::singleton('App\Modules\Publication\Repositories\PublicationCommentTreeArray',
            function()
            {
            return new PublicationCommentTreeArrayEloquent(new PublicationCommentTreeArray());
            }
        );

    PublicationCommentTreeArray::observe(PublicationCommentListener::class);
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
            __DIR__.'/../Config/config.php' => config_path('publication.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'publication'
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
        $viewPath = base_path('resources/views/modules/publication');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/publication';
        }, \Config::get('view.paths')), [$sourcePath]), 'publication');
    }

    /**
     * Регистрация локалей.
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/publication');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'publication');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'publication');
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
