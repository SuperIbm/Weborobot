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
use Image;

use App\Modules\User\Repositories\User;

use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\UserImageAdminReadRequest;
use App\Modules\User\Http\Requests\UserImageAdminCreateRequest;
use App\Modules\User\Http\Requests\UserImageAdminDestroyRequest;


/**
 * Класс контроллер для работы с изображениями пользователя в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserImageAdminController extends Controller
{
/**
 * Репозитарий для выбранных групп пользователя.
 * @var \App\Modules\User\Repositories\User
 * @version 1.0
 * @since 1.0
 */
private $_User;


    /**
     * Конструктор.
     * @param \App\Modules\User\Repositories\User $User Репозитарий пользователей.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $User)
    {
    $this->_User = $User;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\User\Http\Requests\UserImageAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(UserImageAdminReadRequest $Request)
    {
    $data = Image::get($Request->input('id'));

        if($data)
        {
            $data =
            [
            'data' => $data == null ? [] : [$data],
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
     * @param \App\Modules\User\Http\Requests\UserImageAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(UserImageAdminCreateRequest $Request)
    {
    $data = [];
    $data['idImageSmall'] = $Request->file('image')->path();
    $data['idImageMiddle'] = $Request->file('image')->path();

    $idUser = $this->_User->update($Request->input("idUser"), $data);

        if($idUser)
        {
            Log::warning('Изменение изображения пользователя.',
                [
                'module' => "User",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => true,
            'data' => $this->_User->get($Request->input("idUser"))
            ];
        }
        else
        {
            Log::warning('Неудачное изменение изображения пользователя.',
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
     * @param \App\Modules\User\Http\Requests\UserImageAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserImageAdminDestroyRequest $Request)
    {
    $data = $this->_User->get($Request->input('idUser'));

        if($data)
        {
        Image::destroy($data['idImageSmall']['idImage']);
        Image::destroy($data['idImageMiddle']['idImage']);

            $status = $this->_User->update($Request->input('idUser'),
                [
                'idImageSmall' => null,
                'idImageMiddle' => null
                ]
            );

            if($status == true && $this->_User->hasError() == false)
            {
                Log::info('Удаление изображения пользователя.',
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
                Log::warning('Неудачное удаление изображения пользователя.',
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
        }
        else
        {
            Log::warning('Неудачное удаление изображения пользователя.',
                [
                'module' => "User",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }
}
