<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\User\Http\Controllers;

use Log;
use Auth;

use App\Modules\User\Repositories\UserGroup;
use App\Modules\User\Repositories\UserGroupRole;
use App\Modules\User\Repositories\UserGroupPage;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\UserGroupAdminReadRequest;
use App\Modules\User\Http\Requests\UserGroupAdminDestroyRequest;

/**
 * Класс контроллер для работы с группами в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserGroupAdminController extends Controller
{
/**
 * Репозитарий групп.
 * @var \App\Modules\User\Repositories\UserGroup
 * @version 1.0
 * @since 1.0
 */
private $_UserGroup;

/**
 * Репозитарий для выбранных разделов роли.
 * @var \App\Modules\User\Repositories\UserGroupRole
 * @version 1.0
 * @since 1.0
 */
private $_UserGroupRole;

/**
 * Репозитарий для выбранных страниц роли.
 * @var \App\Modules\User\Repositories\UserGroupPage
 * @version 1.0
 * @since 1.0
 */
private $_UserGroupPage;

    /**
     * Конструктор.
     * @param \App\Modules\User\Repositories\UserGroup $UserGroup Репозитарий группы.
     * @param \App\Modules\User\Repositories\UserGroupRole $UserGroupRole Репозитарий для выбранных групп роли.
     * @param \App\Modules\User\Repositories\UserGroupPage $UserGroupPage Репозитарий для выбранных страниц группы.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(UserGroup $UserGroup, UserGroupRole $UserGroupRole, UserGroupPage $UserGroupPage)
    {
    $this->_UserGroup = $UserGroup;
    $this->_UserGroupRole = $UserGroupRole;
    $this->_UserGroupPage = $UserGroupPage;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\User\Http\Requests\UserGroupAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(UserGroupAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idUserGroup',
            'value' => $Request->input('id')
            ];

        $data = $this->_UserGroup->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_UserGroup->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_UserGroup->hasError() == false)
        {
            for($i = 0; $i < count($data); $i++)
            {
                $userGroupPage = $this->_UserGroupPage->read
                (
                    [
                        [
                        'property' => 'idUserGroup',
                        'value' => $data[$i]['idUserGroup']
                        ]
                    ]
                );

                if($userGroupPage) $data[$i]['pages'] = $userGroupPage;

                $userGroupRole = $this->_UserGroupRole->read
                (
                    [
                        [
                        'property' => 'idUserGroup',
                        'value' => $data[$i]['idUserGroup']
                        ]
                    ],
                    null,
                    null,
                    null,
                    [
                    'UserRole'
                    ]
                );

                if($userGroupRole) $data[$i]['roles'] = $userGroupRole;
            }

            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_UserGroup->count($filters),
            'success' => true
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
     * Добавление данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(Request $Request)
    {
    $data = $Request->all();
    $idUserGroup = $this->_UserGroup->create($data);

        if($idUserGroup)
        {
            if($Request->input('roles'))
            {
            $roles = $Request->input('roles');

                foreach($roles as $k => $v)
                {
                $sections[$k]['idUserGroup'] = $idUserGroup;
                $sections[$k]['idUserRole'] = $k;

                $this->_UserGroupRole->create($sections[$k]);
                }
            }

            if($Request->input('pages'))
            {
            $pages = $Request->input('pages');

                foreach($pages as $k => $v)
                {
                    $this->_UserGroupPage->create
                    (
                        [
                        'idUserGroup' => $idUserGroup,
                        'idPage' => $v
                        ]
                    );
                }
            }

            Log::info('Добавление группы.',
                [
                'module' => "UseGroup",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => true
            ];
        }
        else
        {
            Log::warning('Неудачное добавления группы.',
                [
                'module' => "UseGroup",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_UserGroup->getErrorType(),
            'errormsg' => $this->_UserGroup->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Обновление данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function update(Request $Request)
    {
        if($Request->input('idUserGroup'))
        {
        $idUserGroup = $this->_UserGroup->update($Request->input('idUserGroup'), $Request->all());

            if($idUserGroup)
            {
                if($Request->input('isDeleteUserGroupRole'))
                {
                    $userGroupRoles = $this->_UserGroupRole->read
                    (
                        [
                            [
                            'property' => 'idUserGroup',
                            'value' => $idUserGroup
                            ]
                        ]
                    );

                    if($userGroupRoles)
                    {
                        for($i = 0; $i < count($userGroupRoles); $i++)
                        {
                        $this->_UserGroupRole->destroy($userGroupRoles[$i]['idUserGroupRole']);
                        }
                    }
                }

                if($Request->input('roles'))
                {
                $roles = $Request->input('roles');

                    foreach($roles as $k => $v)
                    {
                    $sections[$k]['idUserGroup'] = $idUserGroup;
                    $sections[$k]['idUserRole'] = $k;

                    $this->_UserGroupRole->create($sections[$k]);
                    }
                }

                if($Request->input('isDeleteUserGroupPage'))
                {
                    $userGroupPages = $this->_UserGroupPage->read
                    (
                        [
                            [
                            'property' => 'idUserGroup',
                            'value' => $idUserGroup
                            ]
                        ]
                    );

                    if($userGroupPages)
                    {
                        for($i = 0; $i < count($userGroupPages); $i++)
                        {
                        $this->_UserGroupPage->destroy($userGroupPages[$i]['idUserGroupPage']);
                        }
                    }
                }

                if($Request->input('pages'))
                {
                $pages = $Request->input('pages');

                    foreach($pages as $k => $v)
                    {
                        $this->_UserGroupPage->create
                        (
                            [
                            'idUserGroup' => $idUserGroup,
                            'idPage' => $v
                            ]
                        );
                    }
                }

                Log::info('Обновление группы.',
                    [
                    'module' => "UseGroup",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => true
                ];
            }
            else
            {
                Log::warning('Неудачное обновление группы.',
                    [
                    'module' => "UseGroup",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_UserRole->getErrorType(),
                'errormsg' => $this->_UserRole->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление группы.',
                [
                'module' => "UseGroup",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_UserRole->getErrorType(),
            'errormsg' => $this->_UserRole->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\User\Http\Requests\UserGroupAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserGroupAdminDestroyRequest $Request)
    {
    $status = $this->_UserGroup->destroy($Request->input('idUserGroup'));

        if($status == true && $this->_UserGroup->hasError() == false)
        {
            Log::info('Удаление группы.',
                [
                'module' => "UserGroup",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => true
            ];
        }
        else
        {
            Log::warning('Неудачное удаление группы.',
                [
                'module' => "UserGroup",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_UserGroup->getErrorType(),
            'errormsg' => $this->_UserGroup->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
