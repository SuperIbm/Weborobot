<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Module\Repositories\Module;

use App\Modules\Module\Http\Requests\ModuleAdminReadRequest;
use App\Modules\Module\Http\Requests\ModuleAdminCreateRequest;
use App\Modules\Component\Repositories\Component;

/**
 * Класс контроллер для работы с Модулями в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleAdminController extends Controller
{
/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

/**
 * Репозитарий компонентов.
 * @var \App\Modules\Component\Repositories\Component
 * @version 1.0
 * @since 1.0
 */
private $_Component;

    /**
     * Конструктор.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @param \App\Modules\Component\Repositories\Component $Component Репозитарий компонентов.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Module $Module, Component $Component)
    {
    $this->_Module = $Module;
    $this->_Component = $Component;
    }

    /**
     * Чтение данных.
     * @param \App\Modules\Module\Http\Requests\ModuleAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(ModuleAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idModule',
            'value' => $Request->input('id')
            ];

        $data = $this->_Module->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_Module->read
            (
                $filters,
                null,
                json_decode($Request->input('sort'), true),
                $Request->input('start'),
                $Request->input('limit')
            );
        }

        if($this->_Module->hasError() == false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_Module->count($filters),
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
     * @param \App\Modules\Module\Http\Requests\ModuleAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(ModuleAdminCreateRequest $Request)
    {
    $status = $this->_Module->installModule($Request->input('nameDir'), $Request->file('file')->path());

        if($status)
        {
            Log::info('Установка модуля.',
                [
                'module' => "Module",
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
            Log::warning('Неудачное уствнока модуля.',
                [
                'module' => "Module",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Module->getErrorType(),
            'errormsg' => $this->_Module->getErrorMessage()
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
        if($Request->input('idModule'))
        {
            $status = $this->_Module->update($Request->input('idModule'),
                [
                'status' => $Request->input('status')
                ]
            );

            if($status)
            {
                Log::info('Обновление статуса модуля.',
                    [
                    'module' => "Module",
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
                Log::warning('Неудачное обновление статуса модуля.',
                    [
                    'module' => "Module",
                    'login' => Auth::getUser()->loginn,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Module->getErrorType(),
                'errormsg' => $this->_Module->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление статуса модуля.',
                [
                'module' => "Module",
                'login' => Auth::getUser()->loginn,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Module->getErrorType(),
            'errormsg' => $this->_Module->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Древовидная струткра модулей.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function tree()
    {
        $data = $this->_Module->read
        (
        null,
            null,
            [
                [
                'property' => 'labelModule',
                'direction' => 'ASC'
                ]
            ]
        );

        if($this->_Module->hasError() == false && $data)
        {
        $dataWithComponents = [];

            for($i = 0, $y = 0; $i < count($data); $i++)
            {
                $components = $this->_Component->read
                (
                    [
                        [
                        'property' => 'idModule',
                        'value' => $data[$i]['idModule']
                        ]
                    ],
                    true
                );

                if($components)
                {
                $dataWithComponents[$y]['idModule'] = $data[$i]['idModule'];
                $dataWithComponents[$y]['text'] = $data[$i]['labelModule'];
                $dataWithComponents[$y]['leaf'] = false;
                $dataWithComponents[$y]['children'] = [];
                $dataWithComponents[$y]['icon'] = 'engine/app/Modules/Module/Admin/images/icon_small.png';
                $y++;
                }
            }

        $data = $dataWithComponents;
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
