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

use Carbon\Carbon;
use Path;

use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserGroupOfUser;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\UserAdminReadRequest;
use App\Modules\User\Http\Requests\UserAdminDestroyRequest;

/**
 * Класс контроллер для работы с пользователями в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserAdminController extends Controller
{
/**
 * Репозитарий для выбранных групп пользователя.
 * @var \App\Modules\User\Repositories\User
 * @version 1.0
 * @since 1.0
 */
private $_User;

/**
 * Репозитарий для выбранных групп пользователя.
 * @var \App\Modules\User\Repositories\UserGroupOfUser
 * @version 1.0
 * @since 1.0
 */
private $_UserGroupOfUser;


    /**
     * Конструктор.
     * @param \App\Modules\User\Repositories\User $User Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserGroupOfUser $UserGroupOfUser Репозитарий для выбранных групп пользователя.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $User, UserGroupOfUser $UserGroupOfUser)
    {
    $this->_User = $User;
    $this->_UserGroupOfUser = $UserGroupOfUser;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\User\Http\Requests\UserAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(UserAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idUser',
            'value' => $Request->input('id')
            ];

        $data = $this->_User->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            if($Request->input('idUser'))
            {
                $filters[] =
                [
                'property' => 'idUser',
                'value' => $Request->input('idUser')
                ];
            }

            $data = $this->_User->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_User->hasError() == false)
        {
            for($i = 0; $i < count($data); $i++)
            {
                $userGroupOfUsers = $this->_UserGroupOfUser->read
                (
                    [
                        [
                        'property' => 'idUser',
                        'value' => $data[$i]['idUser']
                        ]
                    ],
                    null,
                    null,
                    null,
                    [
                    'UserGroup'
                    ]
                );

                if($userGroupOfUsers) $data[$i]['groups'] = $userGroupOfUsers;
            }

            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_User->count($filters),
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
    $data["dateAdd"] = Carbon::now();
    $data["ip"] = Path::getUserIp();

        if($Request->hasFile('image') && $Request->file('image')->isValid())
        {
        $data['idImageSmall'] = $Request->file('image')->path();
        $data['idImageMiddle'] = $Request->file('image')->path();
        }

        if($data["birthday"]) $data["birthday"] = Carbon::createFromFormat('d.m.Y', $data["birthday"]);
        else unset($data["birthday"]);

        if($data["passportWhenMade"]) $data["passportWhenMade"] = Carbon::createFromFormat('d.m.Y', $data["passportWhenMade"]);
        else unset($data["passportWhenMade"]);

    $idUser = $this->_User->create($data);

        if($idUser)
        {
            if($Request->input('groups'))
            {
            $groups = $Request->input('groups');

                foreach($groups as $k => $v)
                {
                    $this->_UserGroupOfUser->create
                    (
                       [
                       'idUser' => $idUser,
                       'idUserGroup' => $k
                       ]
                    );
                }
            }

            Log::warning('Добавления пользователя.',
                [
                'module' => "User",
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
            Log::warning('Неудачное добавления пользователя.',
                [
                'module' => "User",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_User->getErrorType(),
            'errormsg' => $this->_User->getErrorMessage()
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
        if($Request->input('idUser'))
        {
        $data = $Request->all();

            if($data['passportWhenMade']) $data['passportWhenMade'] = Carbon::createFromFormat('d.m.Y', $data['passportWhenMade']);
            if($data['birthday']) $data['birthday'] = Carbon::createFromFormat('d.m.Y', $data['birthday']);

        $idUser = $this->_User->update($Request->input('idUser'), $data);

            if($idUser)
            {
                if($Request->input('isUserGroupOfUser'))
                {
                    $userGroupOfUsers = $this->_UserGroupOfUser->read
                    (
                        [
                            [
                            'property' => 'idUser',
                            'value' => $idUser
                            ]
                        ]
                    );

                    if($userGroupOfUsers)
                    {
                        for($i = 0; $i < count($userGroupOfUsers); $i++)
                        {
                        $this->_UserGroupOfUser->destroy($userGroupOfUsers[$i]['idUserGroupOfUser']);
                        }
                    }
                }

                if($Request->input('groups'))
                {
                $groups = $Request->input('groups');

                    foreach($groups as $k => $v)
                    {
                        $this->_UserGroupOfUser->create
                        (
                            [
                            'idUser' => $idUser,
                            'idUserGroup' => $k
                            ]
                        );
                    }
                }

                Log::info('Обновление пользователя.',
                    [
                    'module' => "User",
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
                Log::warning('Неудачное обновление пользователя.',
                    [
                    'module' => "User",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_User->getErrorType(),
                'errormsg' => $this->_User->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление пользователя.',
                [
                'module' => "User",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_User->getErrorType(),
            'errormsg' => $this->_User->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\User\Http\Requests\UserAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserAdminDestroyRequest $Request)
    {
    $status = $this->_User->destroy($Request->input('idUser'));

        if($status == true && $this->_User->hasError() == false)
        {
            Log::info('Удаление пользователя.',
                [
                'module' => "User",
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
            Log::warning('Неудачное удаление пользователя.',
                [
                'module' => "User",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_User->getErrorType(),
            'errormsg' => $this->_User->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
