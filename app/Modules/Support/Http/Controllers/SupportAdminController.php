<?php
/**
 * Модуль Поддержки.
 * Этот модуль содержит все классы для работы поддержкой в административной системе.
 * @package App.Modules.Support
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Support\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Support\Repositories\Support;

use App\Modules\Support\Http\Requests\SupportAdminReadRequest;
use App\Modules\Support\Http\Requests\SupportAdminSendRequest;

use App\Modules\Support\Emails\EmailAdmin;


/**
 * Класс контроллер для работы с поддержкой в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SupportAdminController extends Controller
{
/**
 * Репозитарий шаблонов модулей.
 * @var \App\Modules\Support\Repositories\Support
 * @version 1.0
 * @since 1.0
 */
private $_Support;

    /**
     * Конструктор.
     * @param \App\Modules\Support\Repositories\Support $Support Репозитарий поддержки.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Support $Support)
    {
    $this->_Support = $Support;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\Support\Http\Requests\SupportAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(SupportAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idSupport',
            'value' => $Request->input('id')
            ];

        $data = $this->_Support->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_Support->read
            (
            $filters,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_Support->hasError() == false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_Support->count($filters),
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
     * Обновление данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function update(Request $Request)
    {
        if($Request->input('idSupport'))
        {
        $status = $this->_Support->update($Request->input('idSupport'), $Request->all());

            if($status)
            {
                Log::info('Обновление шаблона данных администратора.',
                    [
                    'module' => "Support",
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
                Log::warning('Неудачное обновление данных администратора.',
                    [
                    'module' => "Support",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Support->getErrorType(),
                'errormsg' => $this->_Support->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление данных администратора.',
                [
                'module' => "Support",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Support->getErrorType(),
            'errormsg' => $this->_Support->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Обновление данных.
     * @param \App\Modules\Support\Http\Requests\SupportAdminSendRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function send(SupportAdminSendRequest $Request)
    {
    $EmailAdmin = new EmailAdmin();

        if($Request->file('file') && $Request->file('file')->isValid()) $file = $Request->file('file')->path();
        else $file = null;

        if($Request->file('file') && $Request->file('file')->isValid()) $fileName = $Request->file('file')->getClientOriginalName();
        else $fileName = null;

        $status = $EmailAdmin->send
        (
            $Request->input('theme'),
            $Request->input('fio'),
            $Request->input('email'),
            $Request->input('message'),
            $Request->input('telephone'),
            $Request->input('url'),
            $file,
            $fileName
        );

        if($status)
        {
            Log::info('Отправка сообщения администратору.',
                [
                'module' => "Support",
                'login' => Auth::getUser()->login,
                'type' => 'send'
                ]
            );

            $data =
            [
            'success' => true
            ];
        }
        else
        {
            Log::warning('Неудачное отправка сообщения администратору.',
                [
                'module' => "Support",
                'login' => Auth::getUser()->login,
                'type' => 'send'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => 'noSend',
            'errormsg' => 'Ошибка отпарвки сообщения администратору сайта.'
            ];
        }

    return response()->json($data);
    }
}
