<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Page\Http\Controllers;

use Log;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

use App\Modules\Page\Repositories\PageTreeArray;
use App\Modules\Page\Http\Requests\PageAdminDestroyRequest;

/**
 * Класс контроллер для страниц сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageAdminController extends Controller
{
/**
 * Репозитарий страниц.
 * @var \App\Modules\Page\Repositories\PageTreeArray
 * @version 1.0
 * @since 1.0
 */
private $_Page;

    /**
     * Конструктор.
     * @param \App\Modules\Page\Repositories\PageTreeArray $Page Репозитарий страниц.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PageTreeArray $Page)
    {
    $this->_Page = $Page;
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
    $data["dateEdit"] = Carbon::now();
    $data["idPageTemplate"] = $data["idPageTemplate"] == "" ? null : $data["idPageTemplate"];

    $idPage = $this->_Page->create($data);

        if($idPage)
        {
            Log::info('Добавление страницы.',
                [
                'module' => "Page",
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
            Log::warning('Неудачное добавление страницы.',
                [
                'module' => "PageTemplate",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Page->getErrorType(),
            'errormsg' => $this->_Page->getErrorMessage()
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
        if($Request->input('idPage'))
        {
        $data = $Request->all();
        $data['dateEdit'] = Carbon::now();
        $data["idPageTemplate"] = $data["idPageTemplate"] == "" ? null : $data["idPageTemplate"];
        $status = $this->_Page->update($Request->input('idPage'), $data);

            if($status)
            {
                Log::info('Обновление страницы.',
                    [
                    'module' => "Page",
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
                Log::warning('Неудачное обновление страницы.',
                    [
                    'module' => "Page",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Page->getErrorType(),
                'errormsg' => $this->_Page->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление страницы.',
                [
                'module' => "Page",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Page\Http\Requests\PageAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PageAdminDestroyRequest $Request)
    {
    $status = $this->_Page->destroy($Request->input('idPage'));

        if($status == true && $this->_Page->hasError() == false)
        {
            Log::info('Удаление страницы.',
                [
                'module' => "Page",
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
            Log::warning('Неудачное удаление страницы.',
                [
                'module' => "Page",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Page->getErrorType(),
            'errormsg' => $this->_Page->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Древовидная струткра модулей.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function tree(Request $Request)
    {
        $data = $this->_Page->read
        (
        null,
        null,
            [
                [
                'property' => 'weight',
                'direction' => 'ASC'
                ]
            ]
        );

        $data = $this->_Page->tree
        (
        $data,
        null,
        null,
        null,
        null,
            [
            'isCheckedAccess' => $Request->input('isCheckedAccess', false)
            ]
        );

        if($this->_Page->hasError() == true)
        {
            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }
}
