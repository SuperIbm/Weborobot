<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Upload\Repositories\UploadSource;

use App\Modules\Upload\Http\Requests\UploadSourceAdminReadRequest;
use App\Modules\Upload\Http\Requests\UploadSourceAdminDestroyRequest;

/**
 * Класс контроллер для работы с источниками обновления в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadSourceAdminController extends Controller
{
/**
 * Репозитарий источников обновления.
 * @var \App\Modules\Upload\Repositories\UploadSource
 * @version 1.0
 * @since 1.0
 */
private $_UploadSource;

    /**
     * Конструктор.
     * @param \App\Modules\Upload\Repositories\UploadSource $UploadSource Репозитарий источников обновления.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(UploadSource $UploadSource)
    {
    $this->_UploadSource = $UploadSource;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\Upload\Http\Requests\UploadSourceAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(UploadSourceAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idUploadSource',
            'value' => $Request->input('id')
            ];

        $data = $this->_UploadSource->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_UploadSource->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_UploadSource->hasError() == false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_UploadSource->count($filters),
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
    $status = $this->_UploadSource->create($data);

        if($status)
        {
            Log::info('Добавление источника обновления.',
                [
                'module' => "Upload",
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
            Log::warning('Неудачное добавления источника обновления.',
                [
                'module' => "Upload",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_UploadSource->getErrorType(),
            'errormsg' => $this->_UploadSource->getErrorMessage()
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
        if($Request->input('idUploadSource'))
        {
        $status = $this->_UploadSource->update($Request->input('idUploadSource'), $Request->all());

            if($status)
            {
                Log::info('Обновление источника обновления.',
                    [
                    'module' => "Upload",
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
                Log::warning('Неудачное обновление источника обновления.',
                    [
                    'module' => "Upload",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_UploadSource->getErrorType(),
                'errormsg' => $this->_UploadSource->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление источника обновления.',
                [
                'module' => "Upload",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_UploadSource->getErrorType(),
            'errormsg' => $this->_UploadSource->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Upload\Http\Requests\UploadSourceAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UploadSourceAdminDestroyRequest $Request)
    {
    $status = $this->_UploadSource->destroy($Request->input('idUploadSource'));

        if($status == true && $this->_UploadSource->hasError() == false)
        {
            Log::info('Удаление источника обновления.',
                [
                'module' => "Upload",
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
            Log::warning('Неудачное удаление источника обновления.',
                [
                'module' => "Upload",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_UploadSource->getErrorType(),
            'errormsg' => $this->_UploadSource->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
