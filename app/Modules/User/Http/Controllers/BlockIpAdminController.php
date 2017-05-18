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

use App\Modules\User\Repositories\BlockIp;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\BlockIpAdminReadRequest;
use App\Modules\User\Http\Requests\BlockIpAdminDestroyRequest;

/**
 * Класс контроллер для работы с блокированными IP в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class BlockIpAdminController extends Controller
{
/**
 * Репозитарий заблокированных IP.
 * @var \App\Modules\User\Repositories\BlockIp
 * @version 1.0
 * @since 1.0
 */
private $_BlockIp;

    /**
     * Конструктор.
     * @param \App\Modules\User\Repositories\BlockIp $BlockIp Репозитарий заблокированных IP.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(BlockIp $BlockIp)
    {
    $this->_BlockIp = $BlockIp;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\User\Http\Requests\BlockIpAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(BlockIpAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idBlockIp',
            'value' => $Request->input('id')
            ];

        $data = $this->_BlockIp->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            if($Request->input('idBlockIp'))
            {
                $filters[] =
                [
                'property' => 'idBlockIp',
                'value' => $Request->input('idBlockIp')
                ];
            }

            $data = $this->_BlockIp->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_BlockIp->hasError() == false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_BlockIp->count($filters),
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
    $status = $this->_BlockIp->create($data);

        if($status)
        {
            Log::info('Добавление заблокированного IP.',
                [
                'module' => "BlockIp",
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
            Log::warning('Неудачное добавления заблокированного IP.',
                [
                'module' => "BlockIp",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_BlockIp->getErrorType(),
            'errormsg' => $this->_BlockIp->getErrorMessage()
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
        if($Request->input('idBlockIp'))
        {
        $status = $this->_BlockIp->update($Request->input('idBlockIp'), $Request->all());

            if($status)
            {
                Log::info('Обновление заблокированного IP.',
                    [
                    'module' => "BlockIp",
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
                Log::warning('Неудачное обновление заблокированного IP.',
                    [
                    'module' => "BlockIp",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_BlockIp->getErrorType(),
                'errormsg' => $this->_BlockIp->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление заблокированного IP.',
                [
                'module' => "BlockIp",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_BlockIp->getErrorType(),
            'errormsg' => $this->_BlockIp->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\User\Http\Requests\BlockIpAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(BlockIpAdminDestroyRequest $Request)
    {
        $status = $this->_BlockIp->destroy($Request->input('idBlockIp'));

        if($status == true && $this->_BlockIp->hasError() == false)
        {
            Log::info('Удаление заблокированного IP.',
                [
                'module' => "BlockIp",
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
            Log::warning('Неудачное удаление заблокированного IP.',
                [
                'module' => "BlockIp",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_BlockIp->getErrorType(),
            'errormsg' => $this->_BlockIp->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
