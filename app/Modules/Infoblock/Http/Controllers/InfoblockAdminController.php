<?php
/**
 * Модуль Инфоблоков.
 * Этот модуль содержит все классы для работы с инфоблоками.
 * @package App.Modules.Infoblock
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Infoblock\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Infoblock\Repositories\Infoblock;

use App\Modules\Infoblock\Http\Requests\InfoblockAdminReadRequest;
use App\Modules\Infoblock\Http\Requests\InfoblockAdminDestroyRequest;

/**
 * Класс контроллер для работы с инфоблоками в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InfoblockAdminController extends Controller
{
/**
 * Репозитарий инфоблоков.
 * @var \App\Modules\Infoblock\Repositories\Infoblock
 * @version 1.0
 * @since 1.0
 */
private $_Infoblock;

    /**
     * Конструктор.
     * @param \App\Modules\Infoblock\Repositories\Infoblock $Infoblock Репозитарий инфоблоков.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Infoblock $Infoblock)
    {
    $this->_Infoblock = $Infoblock;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\Infoblock\Http\Requests\InfoblockAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(InfoblockAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idInfoblock',
            'value' => $Request->input('id')
            ];

        $data = $this->_Infoblock->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_Infoblock->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_Infoblock->hasError() == false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_Infoblock->count($filters),
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
    $status = $this->_Infoblock->create($data);

        if($status)
        {
            Log::info('Добавление инфоблока.',
                [
                'module' => "Infoblock",
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
            Log::warning('Неудачное добавления инфоблока.',
                [
                'module' => "Infoblock",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Infoblock->getErrorType(),
            'errormsg' => $this->_Infoblock->getErrorMessage()
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
        if($Request->input('idInfoblock'))
        {
        $status = $this->_Infoblock->update($Request->input('idInfoblock'), $Request->all());

            if($status)
            {
                Log::info('Обновление инфоблока.',
                    [
                    'module' => "Infoblock",
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
                Log::warning('Неудачное обновление инфоблока.',
                    [
                    'module' => "Infoblock",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Infoblock->getErrorType(),
                'errormsg' => $this->_Infoblock->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление инфоблока.',
                [
                'module' => "Infoblock",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Infoblock->getErrorType(),
            'errormsg' => $this->_Infoblock->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Infoblock\Http\Requests\InfoblockAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(InfoblockAdminDestroyRequest $Request)
    {
    $status = $this->_Infoblock->destroy($Request->input('idInfoblock'));

        if($status == true && $this->_Infoblock->hasError() == false)
        {
            Log::info('Удаление инфоблока.',
                [
                'module' => "Infoblock",
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
            Log::warning('Неудачное удаление инфолока.',
                [
                'module' => "Infoblock",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Infoblock->getErrorType(),
            'errormsg' => $this->_Infoblock->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
