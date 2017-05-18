<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Http\Controllers;

use Config;
use Util;
use Log;
use Auth;
use Illuminate\Routing\Controller;

use App\Modules\Upload\Repositories\Upload;
use App\Modules\Upload\Repositories\UploadSource;
use App\Modules\Upload\Http\Requests\UploadAdminReadRequest;
use App\Modules\Upload\Http\Requests\UploadAdminSetRequest;

/**
 * Класс контроллер для работы с обновлениями в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadAdminController extends Controller
{
/**
 * Репозитарий обновления.
 * @var \App\Modules\Upload\Repositories\Upload
 * @version 1.0
 * @since 1.0
 */
private $_Upload;


/**
 * Репозитарий обновления.
 * @var \App\Modules\Upload\Repositories\UploadSource
 * @version 1.0
 * @since 1.0
 */
private $_UploadSource;

    /**
     * Конструктор.
     * @param \App\Modules\Upload\Repositories\Upload $Upload Репозитарий обновлений.
     * @param \App\Modules\Upload\Repositories\UploadSource $UploadSource Репозитарий источников обновления.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Upload $Upload, UploadSource $UploadSource)
    {
    $this->_Upload = $Upload;
    $this->_UploadSource = $UploadSource;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\Upload\Http\Requests\UploadAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(UploadAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idUpload',
            'value' => $Request->input('id')
            ];

        $data = $this->_Upload->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_Upload->read
            (
            $filters,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit'),
                [
                "Module"
                ]
            );
        }

        if($this->_Upload->hasError() == false)
        {
            if($data)
            {
                for($i = 0; $i < count($data); $i++)
                {
                $data[$i]["module"]["currentVersion"] = Config::get(Util::toLower($data[$i]["module"]['nameModule']).'.version');
                $data[$i]["module"]["currentDate"] = Config::get(Util::toLower($data[$i]["module"]['nameModule']).'.date');
                }
            }

            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_Upload->count($filters),
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
     * Проверка обновления.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function check()
    {
    $rules = $this->_UploadSource->getRules();

        if($rules)
        {
        $status = $this->_Upload->check($rules);

            if($status)
            {
                Log::info('Проверка обновления.',
                    [
                    'module' => "Upload",
                    'login' => Auth::getUser()->login,
                    'type' => 'check'
                    ]
                );

                $data =
                [
                'success' => true
                ];
            }
            else
            {
                Log::warning('Проверка обновления.',
                    [
                    'module' => "Upload",
                    'login' => Auth::getUser()->login,
                    'type' => 'check'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Upload->getErrorType(),
                'errormsg' => $this->_Upload->getErrorMessage()
                ];
            }
        }
        else
        {
            $data =
            [
            'success' => true
            ];
        }

    return response()->json($data);
    }


    /**
     * Установка обновления.
     * @param \App\Modules\Upload\Http\Requests\UploadAdminSetRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function set(UploadAdminSetRequest $Request)
    {
    $rules = $this->_UploadSource->getRules();

        if($rules)
        {
        $status = $this->_Upload->set($Request->input('idUpload'), $rules);

            if($status)
            {
                Log::info('Обновление модуля.',
                    [
                    'module' => "Upload",
                    'login' => Auth::getUser()->login,
                    'type' => 'set'
                    ]
                );

                $data =
                [
                'success' => true
                ];
            }
            else
            {
                Log::warning('Неудачное обновление модуля.',
                    [
                    'module' => "Upload",
                    'login' => Auth::getUser()->login,
                    'type' => 'set'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Upload->getErrorType(),
                'errormsg' => $this->_Upload->getErrorMessage()
                ];
            }
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
}
