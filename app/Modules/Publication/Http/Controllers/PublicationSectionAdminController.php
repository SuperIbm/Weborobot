<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Http\Controllers;

use Log;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Publication\Repositories\PublicationSectionTreeArray;
use App\Modules\Publication\Http\Requests\PublicationSectionAdminDestroyRequest;

/**
 * Класс контроллер для работы с разделами публикайи в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationSectionAdminController extends Controller
{
/**
 * Репозитарий разделов публикаций в виде древовидной структуры.
 * @var \App\Modules\Publication\Repositories\PublicationSectionTreeArray
 * @version 1.0
 * @since 1.0
 */
private $_PublicationSectionTreeArray;

    /**
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\PublicationSectionTreeArray $PublicationSectionTreeArray Репозитарий разделов публикаций в виде древовидной структуры.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PublicationSectionTreeArray $PublicationSectionTreeArray)
    {
    $this->_PublicationSectionTreeArray = $PublicationSectionTreeArray;
    }

    /**
     * Древовидная струткра разделов публикаций.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function tree()
    {
        $data = $this->_PublicationSectionTreeArray->read
        (
        null,
        null,
            [
                [
                'property' => 'labelSection',
                'direction' => 'ASC'
                ]
            ]
        );

    $data = $this->_PublicationSectionTreeArray->tree($data);

        if($this->_PublicationSectionTreeArray->hasError() == true)
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
    $idPage = $this->_PublicationSectionTreeArray->create($Request->all());

        if($idPage)
        {
            Log::info('Добавление раздела публикации.',
                [
                'module' => "Publication",
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
            Log::warning('Неудачное добавление раздела публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PublicationSectionTreeArray->getErrorType(),
            'errormsg' => $this->_PublicationSectionTreeArray->getErrorMessage()
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
        if($Request->input('idPublicationSection'))
        {
        $status = $this->_PublicationSectionTreeArray->update($Request->input('idPublicationSection'), $Request->all());

            if($status)
            {
                Log::info('Обновление раздела публикации.',
                    [
                    'module' => "Publication",
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
                Log::warning('Неудачное обновление раздела публикации.',
                    [
                    'module' => "Publication",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_PublicationSectionTreeArray->getErrorType(),
                'errormsg' => $this->_PublicationSectionTreeArray->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление раздела публикации.',
                [
                'module' => "Publication",
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
     * @param \App\Modules\Publication\Http\Requests\PublicationSectionAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PublicationSectionAdminDestroyRequest $Request)
    {
    $status = $this->_PublicationSectionTreeArray->destroy($Request->input('idPublicationSection'));

        if($status == true && $this->_PublicationSectionTreeArray->hasError() == false)
        {
            Log::info('Удаление раздела публикации.',
                [
                'module' => "Publication",
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
            Log::warning('Неудачное удаление раздела публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PublicationSectionTreeArray->getErrorType(),
            'errormsg' => $this->_PublicationSectionTreeArray->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
