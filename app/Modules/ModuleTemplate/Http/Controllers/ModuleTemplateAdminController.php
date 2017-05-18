<?php
/**
 * Модуль Шаблоны модуля.
 * Этот модуль содержит все классы для работы с шаблонами модулей системы.
 * @package App.Modules.ModuleTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ModuleTemplate\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\ModuleTemplate\Repositories\ModuleTemplate;

use App\Modules\ModuleTemplate\Http\Requests\ModuleTemplateAdminReadRequest;
use App\Modules\ModuleTemplate\Http\Requests\ModuleTemplateAdminDestroyRequest;

/**
 * Класс контроллер для работы с шаблонами модуля в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleTemplateAdminController extends Controller
{
/**
 * Репозитарий шаблонов модулей.
 * @var \App\Modules\ModuleTemplate\Repositories\ModuleTemplate
 * @version 1.0
 * @since 1.0
 */
private $_ModuleTemplate;

    /**
     * Конструктор.
     * @param \App\Modules\ModuleTemplate\Repositories\ModuleTemplate $ModuleTemplate Репозитарий шаблонов модулей.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(ModuleTemplate $ModuleTemplate)
    {
    $this->_ModuleTemplate = $ModuleTemplate;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\ModuleTemplate\Http\Requests\ModuleTemplateAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(ModuleTemplateAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idModuleTemplate',
            'value' => $Request->input('id')
            ];

        $data = $this->_ModuleTemplate->read($filters);
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

            if($Request->input('nameModule'))
            {
                $filters[] =
                [
                'property' => 'nameModule',
                'value' => $Request->input('nameModule')
                ];
            }

            $data = $this->_ModuleTemplate->read
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

        if($this->_ModuleTemplate->hasError() == false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_ModuleTemplate->count($filters),
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
    $status = $this->_ModuleTemplate->create($data);

        if($status)
        {
            Log::info('Добавление шаблона модуля.',
                [
                'module' => "ModuleTemplate",
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
            Log::warning('Неудачное добавления шаблона модуля.',
                [
                'module' => "ModuleTemplate",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_ModuleTemplate->getErrorType(),
            'errormsg' => $this->_ModuleTemplate->getErrorMessage()
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
        if($Request->input('idModuleTemplate'))
        {
        $status = $this->_ModuleTemplate->update($Request->input('idModuleTemplate'), $Request->all());

            if($status)
            {
                Log::info('Обновление шаблона модуля модуля.',
                    [
                    'module' => "ModuleTemplate",
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
                Log::warning('Неудачное обновление шаблона модуля.',
                    [
                    'module' => "ModuleTemplate",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_ModuleTemplate->getErrorType(),
                'errormsg' => $this->_ModuleTemplate->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление шаблона модуля.',
                [
                'module' => "ModuleTemplate",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_ModuleTemplate->getErrorType(),
            'errormsg' => $this->_ModuleTemplate->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\ModuleTemplate\Http\Requests\ModuleTemplateAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(ModuleTemplateAdminDestroyRequest $Request)
    {
    $status = $this->_ModuleTemplate->destroy($Request->input('idModuleTemplate'));

        if($status == true && $this->_ModuleTemplate->hasError() == false)
        {
            Log::info('Удаление шаблона модуля.',
                [
                'module' => "ModuleTemplate",
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
            Log::warning('Неудачное удаление шаблона модуля.',
                [
                'module' => "ModuleTemplate",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_ModuleTemplate->getErrorType(),
            'errormsg' => $this->_ModuleTemplate->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
