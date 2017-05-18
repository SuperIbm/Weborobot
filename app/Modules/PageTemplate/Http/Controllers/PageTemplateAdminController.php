<?php
/**
 * Модуль Шаблоны для страниц.
 * Этот модуль содержит все классы для работы с шаблонами для страниц.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageTemplate\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\PageTemplate\Repositories\PageTemplate;

use App\Modules\PageTemplate\Http\Requests\PageTemplateAdminReadRequest;
use App\Modules\PageTemplate\Http\Requests\PageTemplateAdminDestroyRequest;
use App\Modules\PageTemplate\Http\Requests\PageTemplateAdminCreateRequest;


/**
 * Класс контроллер для работы с шаблонами страниц в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageTemplateAdminController extends Controller
{
/**
 * Репозитарий шаблонов страниц.
 * @var \App\Modules\PageTemplate\Repositories\PageTemplate
 * @version 1.0
 * @since 1.0
 */
private $_PageTemplate;

    /**
     * Конструктор.
     * @param \App\Modules\PageTemplate\Repositories\PageTemplate $PageTemplate Репозитарий шаблонов страниц.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PageTemplate $PageTemplate)
    {
    $this->_PageTemplate = $PageTemplate;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\PageTemplate\Http\Requests\PageTemplateAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(PageTemplateAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idPagaTemplate',
            'value' => $Request->input('id')
            ];

        $data = $this->_PageTemplate->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_PageTemplate->read
            (
                $filters,
                null,
                json_decode($Request->input('sort'), true),
                $Request->input('start'),
                $Request->input('limit')
            );
        }

        if($this->_PageTemplate->hasError() == false)
        {
            $data =
            [
            "data" => $data == null ? [] : $data,
            "total" => $this->_PageTemplate->count($filters),
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
     * @param \App\Modules\PageTemplate\Http\Requests\PageTemplateAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(PageTemplateAdminCreateRequest $Request)
    {
    $data = $Request->all();

        if($Request->hasFile('image') && $Request->file('image')->isValid()) $data['idImage'] = $Request->file('image')->path();

    $idPageTemplate = $this->_PageTemplate->create($data, $Request->file('template')->path());

        if($idPageTemplate)
        {
            Log::info('Добавление шаблона страницы.',
                [
                'module' => "PageTemplate",
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
            Log::warning('Неудачное добавление шаблона страницы.',
                [
                'module' => "PageTemplate",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PageTemplate->getErrorType(),
            'errormsg' => $this->_PageTemplate->getErrorMessage()
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
        if($Request->input('idPageTemplate'))
        {
        $data = $Request->all();

            if($Request->hasFile('image') && $Request->file('image')->isValid()) $data['idImage'] = $Request->file('image')->path();
            else unset($data['idImage']);

            if($Request->file('template')) $file = $Request->file('template')->path();
            else $file = null;

        $status = $this->_PageTemplate->update($Request->input('idPageTemplate'), $data, $file);

            if($status)
            {
                Log::info('Обновление шаблона страницы.',
                    [
                    'module' => "PageTemplate",
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
                Log::warning('Неудачное обновление шаблона страницы.',
                    [
                    'module' => "PageTemplate",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_PageTemplate->getErrorType(),
                'errormsg' => $this->_PageTemplate->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление шаблона страницы.',
                [
                'module' => "PageTemplate",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PageTemplate->getErrorType(),
            'errormsg' => $this->_PageTemplate->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\PageTemplate\Http\Requests\PageTemplateAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PageTemplateAdminDestroyRequest $Request)
    {
    $status = $this->_PageTemplate->destroy($Request->input('idPageTemplate'));

        if($status == true && $this->_PageTemplate->hasError() == false)
        {
            Log::info('Удаление шаблона страницы.',
                [
                'module' => "PageTemplate",
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
            Log::warning('Неудачное удаление шаблона страницы.',
                [
                'module' => "PageTemplate",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PageTemplate->getErrorType(),
            'errormsg' => $this->_PageTemplate->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
