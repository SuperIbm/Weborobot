<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 * @package App.Modules.Access
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Access\Http\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use Gate;
use Action;
use App\Modules\Access\Http\Requests\AccessAdminAttempRequest;
use App\Modules\User\Repositories\User;
use App\Modules\AdminSection\Repositories\AdminSection;
use App\Modules\Widget\Repositories\Widget;
use App\Modules\Module\Repositories\Module;
use App\Modules\Component\Repositories\Component;
use Config;


/**
 * Класс контроллер для авторизации и аунтификации: администратора.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessAdminController extends Controller
{
/**
 * Репозитарий пользователей.
 * @var \App\Modules\User\Repositories\User
 * @version 1.0
 * @since 1.0
 */
private $_User;

/**
 * Репозитарий разделов административной системы.
 * @var \App\Modules\AdminSection\Repositories\AdminSection
 * @version 1.0
 * @since 1.0
 */
private $_AdminSection;

/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

/**
 * Репозитарий компонентов.
 * @var \App\Modules\Component\Repositories\Component
 * @version 1.0
 * @since 1.0
 */
private $_Component;

/**
 * Репозитарий виджетов.
 * @var \App\Modules\Widget\Repositories\Widget
 * @version 1.0
 * @since 1.0
 */
private $_Widget;


    /**
     * Конструктор.
     * @param \App\Modules\User\Repositories\User $User Репозитарий пользователей.
     * @param \App\Modules\AdminSection\Repositories\AdminSection $AdminSection Репозитарий разделов административной системы.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @param \App\Modules\Component\Repositories\Component $Component Репозитарий компонентов.
     * @param \App\Modules\Widget\Repositories\Widget $Widget Репозитарий виджетов.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $User, AdminSection $AdminSection, Module $Module, Component $Component, Widget $Widget)
    {
    $this->_User = $User;
    $this->_AdminSection = $AdminSection;
    $this->_Module = $Module;
    $this->_Component = $Component;
    $this->_Widget = $Widget;
    }


    /**
     * Аунтификация администратора.
     * @param \App\Modules\Access\Http\Requests\AccessAdminAttempRequest $Request Запрос с проверкой.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function attempt(AccessAdminAttempRequest $Request)
    {
    $status = Action::status('AccessAdminAttempt', 5, 30);

        if($status)
        {
        Action::add('AccessAdminAttempt');

            $status = Auth::attempt
            (
                [
                'login' => $Request->input('login'),
                'password' => $Request->input('password')
                ]
            );

            if($status)
            {
            $status = Gate::allows('admin');

                if($status)
                {
                    $data =
                    [
                    'success' => true,
                    'data' => $this->_getParams(Auth::getUser()["idUser"])
                    ];
                }
                else
                {
                    $data =
                    [
                    'success' => false,
                    'errortype' => 'noAdmin',
                    'errormsg' => 'Вы не можете войти в систему, т.к. у этого пользователя нет прав на администрирования!'
                    ];
                }
            }
            else
            {
                $data =
                [
                'success' => false,
                'errortype' => 'noUser',
                'errormsg' => 'Пользователь с такими данными не найден!'
                ];
            }
        }
        else
        {
            $data =
            [
            'success' => false,
            'errortype' => 'limitActions',
            'errormsg' => 'Превышен лимит возможности войти в систему, попробуйте повторить операцию через 30 минут!'
            ];
        }

    return response()->json($data);
    }


    /**
     * Авторизация администратора.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function gate()
    {
    $status = Gate::allows('admin');

        if($status)
        {
            $data =
            [
            'success' => true,
            'data' => $this->_getParams(Auth::getUser()["idUser"])
            ];
        }
        else
        {
            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }


    /**
     * Выход авторизованного администратора.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function logout()
    {
    Auth::logout();
    return response()->json(['success' => true]);
    }


    /**
     * Получение параметров для работы административной системы.
     * @param int $idUser ID пользователя.
     * @return array Возвращает массив из параметров, которые нужны для работы административной системы.
     * @since 1.0
     * @version 1.0
     */
    private function _getParams($idUser)
    {
    $data = $this->_User->gates($idUser);
    $data['user'] = Auth::getUser();
    unset($data['user']['password']);

    $groups = $data['groups'];
    $data['groups'] = [];

        for($i = 0; $i < count($groups); $i++)
        {
        $data['groups'][] =  $groups[$i]['nameGroup'];
        }

    $roles = $data['roles'];
    $data['roles'] = [];

        for($i = 0; $i < count($roles); $i++)
        {
        $data['roles'][] =  $roles[$i]['nameRole'];
        }

    $data['modules'] = [];
    $modules = $this->_Module->read(null, true);

        for($i = 0; $i < count($modules); $i++)
        {
        $data['modules'][$modules[$i]['nameModule']] = $modules[$i];

            $components = $this->_Component->read
            (
                [
                    [
                    'property' => 'idModule',
                    'value' => $modules[$i]['idModule']
                    ]
                ],
                true
            );

            if($components)
            {
            $data['modules'][$modules[$i]['nameModule']]['components'] = [];

                for($z = 0; $z < count($components); $z++)
                {
                $data['modules'][$modules[$i]['nameModule']]['components'][$components[$z]['nameComponent']] = $components[$z];
                }
            }

            $widgets = $this->_Widget->read
            (
                [
                    [
                    'property' => 'idModule',
                    'value' => $modules[$i]['idModule']
                    ]
                ],
                true
            );

            if($widgets)
            {
            $data['modules'][$modules[$i]['nameModule']]['widgets'] = [];

                for($z = 0; $z < count($widgets); $z++)
                {
                    $data['modules'][$modules[$i]['nameModule']]['widgets'][$widgets[$z]['actionWidget']] = $widgets[$z];
                }
            }
        }

        foreach($data['sections'] as $k => $v)
        {
            foreach($data['sections'][$k] as $k2 => $v2)
            {
                if($data['sections'][$k][$k2] == 'Да') $data['sections'][$k][$k2] = true;
                else $data['sections'][$k][$k2] = false;
            }

            $section = $this->_AdminSection->read
            (
                [
                    [
                    'property' => 'nameModule',
                    'value' => $k
                    ]
                ],
                true,
                null,
                null,
                null,
                [
                'Module'
                ]
            );

            if($section) $data['sections'][$k] = array_merge($data['sections'][$k], $section[0]);
        }

        uasort($data['sections'],
            function($a, $b)
            {
                if ($a['weight'] == $b['weight']) return 0;
                return ($a['weight'] < $b['weight']) ? -1 : 1;
            }
        );

        $data['settings'] =
        [
        'appCss' => Config::get('app.css'),
        'name' => Config::get('app.name')
        ];

    return $data;
    }
}
