<?php
/**
 * Модуль Псевдонимы.
 * Этот модуль содержит все классы для работы с псевдонимами.
 * @package App.Modules.Alias
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Alias\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Alias\Repositories\Alias;
use App\Modules\Page\Repositories\Page;

use App\Modules\Alias\Http\Requests\AliasAdminReadRequest;
use App\Modules\Alias\Http\Requests\AliasAdminDestroyRequest;

/**
 * Класс контроллер для работы с псевдонимами в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AliasAdminController extends Controller
{
/**
 * Репозитарий псевдонимов.
 * @var \App\Modules\Alias\Repositories\Alias
 * @version 1.0
 * @since 1.0
 */
private $_Alias;

/**
 * Репозитарий страниц.
 * @var \App\Modules\Page\Repositories\Page
 * @version 1.0
 * @since 1.0
 */
private $_Page;

    /**
     * Конструктор.
     * @param \App\Modules\Alias\Repositories\Alias $Alias Репозитарий псевдонимов.
     * @param \App\Modules\Page\Repositories\Page $Alias Репозитарий страниц.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Alias $Alias, Page $Page)
    {
    $this->_Alias = $Alias;
    $this->_Page = $Page;
    }


    /**
     * Чтение данных.
     * @param \App\Modules\Alias\Http\Requests\AliasAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(AliasAdminReadRequest $Request)
    {
        $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idAlias',
            'value' => $Request->input('id')
            ];

        $data = $this->_Alias->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_Alias->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_Alias->hasError() == false)
        {
            if($data)
            {
                for($i = 0; $i < count($data); $i++)
                {
                $data[$i]['page'] = $this->_Page->get($data[$i]['idPage'], null, true);
                }
            }

            $data =
            [
            "data" => $data == null ? [] : $data,
            "total" => $this->_Alias->count($filters),
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
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(Request $Request)
    {
    $idAlias = $this->_Alias->create($Request->all());

        if($idAlias)
        {
            Log::info('Добавление псевдонима.',
                [
                'module' => "Alias",
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
            Log::warning('Неудачное добавление псевдонима.',
                [
                'module' => "Alias",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Alias->getErrorType(),
            'errormsg' => $this->_Alias->getErrorMessage()
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
        if($Request->input('idAlias'))
        {
        $status = $this->_Alias->update($Request->input('idAlias'), $Request->all());

            if($status)
            {
                Log::info('Обновление псевдонима.',
                    [
                    'module' => "Alias",
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
                Log::warning('Неудачное обновление псевдонима.',
                    [
                    'module' => "Alias",
                    'login' => Auth::getUser()->login,
                    'type' => 'create'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Alias->getErrorType(),
                'errormsg' => $this->_Alias->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление псевдонима.',
                [
                'module' => "Alias",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Alias->getErrorType(),
            'errormsg' => $this->_Alias->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Alias\Http\Requests\AliasAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(AliasAdminDestroyRequest $Request)
    {
    $status = $this->_Alias->destroy($Request->input('idAlias'));

        if($status == true && $this->_Alias->hasError() == false)
        {
            Log::info('Удаление псевдонима.',
                [
                'module' => "Alias",
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
            Log::warning('Неудачное удаление псевдонима.',
                [
                'module' => "Alias",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Alias->getErrorType(),
            'errormsg' => $this->_Alias->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
