<?php
/**
 * Основные провайдеры.
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */
namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use App\Modules\Access\Models\AccessUserProvider;

/**
 * Класс сервис-провайдера для авторизации.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Список политки.
     * @var array
     */
    protected $policies =
    [
    'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Обработчик события загрузки приложения.
     * @param \Illuminate\Contracts\Auth\Access\Gate $Gate Проверка права.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot(GateContract $Gate)
    {
    $this->registerPolicies();

        Auth::provider('access', function($App)
	        {
            return new AccessUserProvider($App->make('App\Modules\User\Repositories\User'), $App->make('App\Modules\User\Repositories\BlockIp'));
	        }
        );

    $Gate->define('section', 'App\Modules\Access\Models\GateSection@check');
    $Gate->define('page', 'App\Modules\Access\Models\GatePage@check');
    $Gate->define('pageUpdate', 'App\Modules\Access\Models\GatePageUpdate@check');
    $Gate->define('role', 'App\Modules\Access\Models\GateRole@check');
    $Gate->define('group', 'App\Modules\Access\Models\GateGroup@check');
    $Gate->define('admin', 'App\Modules\Access\Models\GateAdmin@check');
    $Gate->define('user', 'App\Modules\Access\Models\GateUser@check');
    }
}
