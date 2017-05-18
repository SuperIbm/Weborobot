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

use App\Modules\User\Repositories\UserRole;
use App\Modules\User\Repositories\UserRoleAdminSection;
use App\Modules\User\Repositories\UserRolePage;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\UserRoleAdminReadRequest;
use App\Modules\User\Http\Requests\UserRoleAdminDestroyRequest;

/**
 * Класс контроллер для работы с ролями в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRoleAdminController extends Controller
{
/**
 * Репозитарий ролей.
 * @var \App\Modules\User\Repositories\UserRole
 * @version 1.0
 * @since 1.0
 */
private $_UserRole;

/**
 * Репозитарий для выбранных разделов роли.
 * @var \App\Modules\User\Repositories\UserRoleAdminSection
 * @version 1.0
 * @since 1.0
 */
private $_UserRoleAdminSection;

/**
 * Репозитарий для выбранных страниц роли.
 * @var \App\Modules\User\Repositories\UserRolePage
 * @version 1.0
 * @since 1.0
 */
private $_UserRolePage;

    /**
     * Конструктор.
     * @param \App\Modules\User\Repositories\UserRole $UserRole Репозитарий ролей.
     * @param \App\Modules\User\Repositories\UserRoleAdminSection $UserRoleAdminSection Репозитарий для выбранных разделов роли.
     * @param \App\Modules\User\Repositories\UserRolePage $UserRolePage Репозитарий для выбранных страниц роли.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(UserRole $UserRole, UserRoleAdminSection $UserRoleAdminSection, UserRolePage $UserRolePage)
    {
    $this->_UserRole = $UserRole;
    $this->_UserRoleAdminSection = $UserRoleAdminSection;
    $this->_UserRolePage = $UserRolePage;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\User\Http\Requests\UserRoleAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(UserRoleAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idUserRole',
            'value' => $Request->input('id')
            ];

        $data = $this->_UserRole->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            if($Request->input('idUserRole'))
            {
                $filters[] =
                [
                'property' => 'idUserRole',
                'value' => $Request->input('idUserRole')
                ];
            }

            $data = $this->_UserRole->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_UserRole->hasError() == false)
        {
            for($i = 0; $i < count($data); $i++)
            {
                $userRolePage = $this->_UserRolePage->read
                (
                    [
                        [
                        'property' => 'idUserRole',
                        'value' => $data[$i]['idUserRole']
                        ]
                    ]
                );

                if($userRolePage) $data[$i]['pages'] = $userRolePage;
            }

            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_UserRole->count($filters),
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
    $idUserRole = $this->_UserRole->create($data);

        if($idUserRole)
        {
            if($Request->input('sections'))
            {
            $sections = $Request->input('sections');

                foreach($sections as $k => $v)
                {
                $sections[$k]['idUserRole'] = $idUserRole;
                $sections[$k]['idAdminSection'] = $k;

                $this->_UserRoleAdminSection->create($sections[$k]);
                }
            }

            if($Request->input('pages'))
            {
            $pages = $Request->input('pages');

                foreach($pages as $k => $v)
                {
                    $this->_UserRolePage->create
                    (
                        [
                        'idUserRole' => $idUserRole,
                        'idPage' => $v
                        ]
                    );
                }
            }

            Log::info('Добавление роли.',
                [
                'module' => "UserRole",
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
            Log::warning('Неудачное добавления роли.',
                [
                'module' => "UserRole",
                'login' => Auth::getUser()->login,
                'type' => 'create'
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
     * Обновление данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function update(Request $Request)
    {
        if($Request->input('idUserRole'))
        {
        $idUserRole = $this->_UserRole->update($Request->input('idUserRole'), $Request->all());

            if($idUserRole)
            {
                if($Request->input('isDeleteUserRoleAdminSection'))
                {
                    $userRoleAdminSections = $this->_UserRoleAdminSection->read
                    (
                        [
                            [
                            'property' => 'idUserRole',
                            'value' => $idUserRole
                            ]
                        ]
                    );

                    if($userRoleAdminSections)
                    {
                        for($i = 0; $i < count($userRoleAdminSections); $i++)
                        {
                        $this->_UserRoleAdminSection->destroy($userRoleAdminSections[$i]['idUserRoleAdminSection']);
                        }
                    }
                }

                if($Request->input('sections'))
                {
                $sections = $Request->input('sections');

                    foreach($sections as $k => $v)
                    {
                    $sections[$k]['idUserRole'] = $idUserRole;
                    $sections[$k]['idAdminSection'] = $k;

                    $this->_UserRoleAdminSection->create($sections[$k]);
                    }
                }

                if($Request->input('isDeleteUserRolePage'))
                {
                    $userRolePages = $this->_UserRolePage->read
                    (
                        [
                            [
                            'property' => 'idUserRole',
                            'value' => $idUserRole
                            ]
                        ]
                    );

                    if($userRolePages)
                    {
                        for($i = 0; $i < count($userRolePages); $i++)
                        {
                        $this->_UserRolePage->destroy($userRolePages[$i]['idUserRolePage']);
                        }
                    }
                }

                if($Request->input('pages'))
                {
                $pages = $Request->input('pages');

                    foreach($pages as $k => $v)
                    {
                        $this->_UserRolePage->create
                        (
                            [
                            'idUserRole' => $idUserRole,
                            'idPage' => $v
                            ]
                        );
                    }
                }

                Log::info('Обновление роли.',
                    [
                    'module' => "UserRole",
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
                Log::warning('Неудачное обновление роли.',
                    [
                    'module' => "UserRole",
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
            Log::warning('Неудачное обновление роли.',
                [
                'module' => "UserRole",
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
     * @param \App\Modules\User\Http\Requests\UserRoleAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserRoleAdminDestroyRequest $Request)
    {
    $status = $this->_UserRole->destroy($Request->input('idUserRole'));

        if($status == true && $this->_UserRole->hasError() == false)
        {
            Log::info('Удаление роли.',
                [
                'module' => "UserRole",
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
            Log::warning('Неудачное удаление роли.',
                [
                'module' => "UserRole",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
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
}
