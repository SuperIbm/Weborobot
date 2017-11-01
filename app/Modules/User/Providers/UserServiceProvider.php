<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Providers;

use App;
use Validator;
use Illuminate\Support\ServiceProvider;

use App\Modules\User\Models\BlockIpEloquent as BlockIp;
use App\Modules\User\Repositories\BlockIpEloquent;

use App\Modules\User\Models\UserEloquent as User;
use App\Modules\User\Repositories\UserEloquent;
use App\Modules\User\Events\Listeners\UserListener;

use App\Modules\User\Models\UserGroupEloquent as UserGroup;
use App\Modules\User\Repositories\UserGroupEloquent;
use App\Modules\User\Events\Listeners\UserGroupListener;

use App\Modules\User\Models\UserGroupOfUserEloquent as UserGroupOfUser;
use App\Modules\User\Repositories\UserGroupOfUserEloquent;

use App\Modules\User\Models\UserGroupPageEloquent as UserGroupPage;
use App\Modules\User\Repositories\UserGroupPageEloquent;

use App\Modules\User\Models\UserGroupRoleEloquent as UserGroupRole;
use App\Modules\User\Repositories\UserGroupRoleEloquent;

use App\Modules\User\Models\UserRoleEloquent as UserRole;
use App\Modules\User\Repositories\UserRoleEloquent;
use App\Modules\User\Events\Listeners\UserRoleListener;

use App\Modules\User\Models\UserRoleAdminSectionEloquent as UserRoleAdminSection;
use App\Modules\User\Repositories\UserRoleAdminSectionEloquent;

use App\Modules\User\Models\UserRolePageEloquent as UserRolePage;
use App\Modules\User\Repositories\UserRolePageEloquent;


/**
 * Класс сервис-провайдера для настройки этого модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserServiceProvider extends ServiceProvider
{
/**
 * Индификатор отложенной загрузки.
 * @var bool
 * @version 1.0
 * @since 1.0
 */
protected $defer = false;

    /**
     * Обработчик события загрузки приложения.
     * @return void
	 * @version 1.0
 	 * @since 1.0
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
	 * @version 1.0
 	 * @since 1.0
     */
    public function register()
    {
	    Validator::extend('ipMask',
		    function($attribute, $value, $parameters, $validator)
		    {
		    return preg_match('/^(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))$/', $value);
	        }
	    );

        App::singleton('App\Modules\User\Repositories\BlockIp',
            function()
            {
            return new BlockIpEloquent(new BlockIp());
            }
        );

        App::singleton('App\Modules\User\Repositories\User',
            function()
            {
            return new UserEloquent(new User());
            }
        );

    User::observe(UserListener::class);

        App::singleton('App\Modules\User\Repositories\UserGroup',
            function()
            {
            return new UserGroupEloquent(new UserGroup());
            }
        );

    UserGroup::observe(UserGroupListener::class);

        App::singleton('App\Modules\User\Repositories\UserGroupOfUser',
            function()
            {
            return new UserGroupOfUserEloquent(new UserGroupOfUser());
            }
        );

        App::singleton('App\Modules\User\Repositories\UserGroupPage',
            function()
            {
            return new UserGroupPageEloquent(new UserGroupPage());
            }
        );

        App::singleton('App\Modules\User\Repositories\UserGroupRole',
            function()
            {
            return new UserGroupRoleEloquent(new UserGroupRole());
            }
        );

        App::singleton('App\Modules\User\Repositories\UserRole',
            function()
            {
            return new UserRoleEloquent(new UserRole());
            }
        );

    UserRole::observe(UserRoleListener::class);

        App::singleton('App\Modules\User\Repositories\UserRoleAdminSection',
            function()
            {
            return new UserRoleAdminSectionEloquent(new UserRoleAdminSection());
            }
        );

        App::singleton('App\Modules\User\Repositories\UserRolePage',
            function()
            {
            return new UserRolePageEloquent(new UserRolePage());
            }
        );
    }

    /**
     * Регистрация настроек.
     * @return void
	 * @version 1.0
 	 * @since 1.0
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('user.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'user'
        );
    }

    /**
     * Регистрация представлений.
     * @return void
	 * @version 1.0
 	 * @since 1.0
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/user');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/user';
        }, \Config::get('view.paths')), [$sourcePath]), 'user');
    }

    /**
     * Регистрация локалей.
     * @return void
	 * @version 1.0
 	 * @since 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/user');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'user');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'user');
        }
    }

	/**
	 * Получение сервисов через сервис-провайдер.
	 * @return array
	 * @version 1.0
 	 * @since 1.0
	 */
    public function provides()
    {
        return [];
    }
}
