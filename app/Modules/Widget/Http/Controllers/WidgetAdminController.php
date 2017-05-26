<?php
/**
 * Модуль Виджеты.
 * Этот модуль содержит все классы для работы с виджетами.
 * @package App.Modules.Widget
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Widget\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Widget\Repositories\Widget;

use App\Modules\Widget\Http\Requests\WidgetAdminReadRequest;
use App\Modules\Widget\Http\Requests\WidgetAdminCreateRequest;


/**
 * Класс контроллер для работы с виджетами в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class WidgetAdminController extends Controller
{
/**
 * Репозитарий виджетов.
 * @var \App\Modules\Widget\Repositories\Widget
 * @version 1.0
 * @since 1.0
 */
private $_Widget;

    /**
     * Конструктор.
     * @param \App\Modules\Widget\Repositories\Widget $Widget Репозитарий виджетов.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Widget $Widget)
    {
    $this->_Widget = $Widget;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\Widget\Http\Requests\WidgetAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(WidgetAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idWidget',
            'value' => $Request->input('id')
            ];

        $data = $this->_Widget->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_Widget->read
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

        if($this->_Widget->hasError() == false)
        {
            $data =
            [
            "data" => $data == null ? [] : $data,
            "total" => $this->_Widget->count($filters),
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
     * @param \App\Modules\Widget\Http\Requests\WidgetAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(WidgetAdminCreateRequest $Request)
    {
    $idWidget = $this->_Widget->install($Request->input('nameDir'), $Request->file('file')->path());

        if($idWidget)
        {
            Log::info('Установка виджета.',
                [
                'module' => "Widget",
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
            Log::warning('Неудачное установка виджета.',
                [
                'module' => "Widget",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Widget->getErrorType(),
            'errormsg' => $this->_Widget->getErrorMessage()
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
        if($Request->input('idWidget'))
        {
        $data = $Request->all();
        unset($data['actionWidget']);
        unset($data['labelWidget']);

        $status = $this->_Widget->update($Request->input('idWidget'), $data);

            if($status)
            {
                Log::info('Обновление виджета.',
                    [
                    'module' => "Widget",
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
                Log::warning('Неудачное обновление виджета.',
                    [
                    'module' => "Widget",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Widget->getErrorType(),
                'errormsg' => $this->_Widget->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление виджета.',
                [
                'module' => "Widget",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Widget->getErrorType(),
            'errormsg' => $this->_Widget->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
