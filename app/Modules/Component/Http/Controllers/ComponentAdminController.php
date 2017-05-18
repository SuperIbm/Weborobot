<?php
/**
 * Модуль Компонента.
 * Этот модуль содержит все классы для работы с компонентами системы.
 * @package App.Modules.Component
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Component\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Component\Repositories\Component;

use App\Modules\Component\Http\Requests\ComponentAdminReadRequest;
use App\Modules\Component\Http\Requests\ComponentAdminCreateRequest;

use App\Modules\Module\Repositories\Module;


/**
 * Класс контроллер для работы с компонентами в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ComponentAdminController extends Controller
{
/**
 * Репозитарий виджетов.
 * @var \App\Modules\Component\Repositories\Component
 * @version 1.0
 * @since 1.0
 */
private $_Component;

/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

    /**
     * Конструктор.
     * @param \App\Modules\Component\Repositories\Component $Component Репозитарий виджетов.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Component $Component, Module $Module)
    {
    $this->_Component = $Component;
    $this->_Module = $Module;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\Component\Http\Requests\ComponentAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(ComponentAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idComponent',
            'value' => $Request->input('id')
            ];

        $data = $this->_Component->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            if($Request->input('idModule'))
            {
                $filters[] =
                [
                'property' => 'idModule',
                'value' => $Request->input('idModule')
                ];
            }

            $data = $this->_Component->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit'),
                [
                'Module'
                ]
            );
        }

        if($this->_Component->hasError() == false)
        {
            $data =
            [
            "data" => $data == null ? [] : $data,
            "total" => $this->_Component->count($filters),
            "success" => true
            ];
        }
        else
        {
            $data =
            [
            "success" => false
            ];
        }

    return response()->json($data);
    }

    /**
     * Добавление данных.
     * @param \App\Modules\Component\Http\Requests\ComponentAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(ComponentAdminCreateRequest $Request)
    {
    $idComponent = $this->_Module->installComponent($Request->input('nameDir'), $Request->file('file')->path());

        if($idComponent)
        {
            Log::info('Установка компонента.',
                [
                'module' => "Component",
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
            Log::warning('Неудачное установка компонента.',
                [
                'module' => "Component",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Component->getErrorType(),
            'errormsg' => $this->_Component->getErrorMessage()
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
        if($Request->input('idComponent'))
        {
        $data = $Request->all();
        unset($data['idModule']);
        unset($data['nameBundle']);
        unset($data['nameComponent']);

        $status = $this->_Component->update($Request->input('idComponent'), $data);

            if($status)
            {
                Log::info('Обновление компонента.',
                    [
                    'module' => "Component",
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
                Log::warning('Неудачное обновление компонента.',
                    [
                    'module' => "Component",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Component->getErrorType(),
                'errormsg' => $this->_Component->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление компонента.',
                [
                'module' => "Component",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Component->getErrorType(),
            'errormsg' => $this->_Component->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
