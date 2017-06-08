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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Publication\Repositories\PublicationCommentTreeArray;
use App\Modules\Publication\Http\Requests\PublicationCommentTreeAdminTreeRequest;
use App\Modules\Publication\Http\Requests\PublicationCommentTreeAdminDestroyRequest;

/**
 * Класс контроллер для работы с комментариями в виде древовидной структуры в публикации в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationCommentTreeAdminController extends Controller
{
/**
 * Репозитарий комментариев в публикации в виде древовидной структуры.
 * @var \App\Modules\Publication\Repositories\PublicationCommentTreeArray
 * @version 1.0
 * @since 1.0
 */
private $_PublicationCommentTreeArray;

    /**
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\PublicationCommentTreeArray $PublicationCommentTreeArray Репозитарий комментариев в публикации в виде древовидной структуры.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PublicationCommentTreeArray $PublicationCommentTreeArray)
    {
    $this->_PublicationCommentTreeArray = $PublicationCommentTreeArray;
    }

    /**
     * Древовидная струткра комментариев публикации.
     * @param \App\Modules\Publication\Http\Requests\PublicationCommentTreeAdminTreeRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function tree(PublicationCommentTreeAdminTreeRequest $Request)
    {
        $data = $this->_PublicationCommentTreeArray->read
        (
            [
                [
                'property' => 'idPublication',
                'value' => $Request->input('idPublication')
                ]
            ],
        null,
            [
                [
                'property' => 'dateAdd',
                'direction' => 'DESC'
                ]
            ]
        );

    $data = $this->_PublicationCommentTreeArray->tree($data);

        if($this->_PublicationCommentTreeArray->hasError() == true)
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
    $data['dateAdd'] = Carbon::createFromFormat('d.m.Y H:i:s', $data['dateAdd'].' '.$data['timeAdd']);

        if($Request->hasFile('image') && $Request->file('image')->isValid())
        {
        $data['idImageSmall'] = $Request->file('image')->path();
        $data['idImageMiddle'] = $Request->file('image')->path();
        $data['idImageBig'] = $Request->file('image')->path();
        }

        if(@$data['idPublicationCommentReferen'] == -1) unset($data['idPublicationCommentReferen']);

    $idPublicationComment = $this->_PublicationCommentTreeArray->create($data);

        if($idPublicationComment)
        {
            Log::info('Добавление комментария в публикацию.',
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
            Log::warning('Неудачное добавление комментария в публикацию.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PublicationCommentTreeArray->getErrorType(),
            'errormsg' => $this->_PublicationCommentTreeArray->getErrorMessage()
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
        if($Request->input('idPublicationComment'))
        {
        $data = $Request->all();

            if(!strpos($data["dateAdd"], " "))
            {
            $dateAddAr = explode(" ", $data["dateAdd"]);
            $data["dateAdd"] = $dateAddAr[0];
            $data["dateAdd"] .= " ".$data["timeAdd"];
            $data['dateAdd'] = Carbon::createFromFormat('d.m.Y H:i:s', $data['dateAdd']);
            }
            else $data['dateAdd'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['dateAdd']);

            if($Request->hasFile('image') && $Request->file('image')->isValid())
            {
            $data['idImageSmall'] = $Request->file('image')->path();
            $data['idImageMiddle'] = $Request->file('image')->path();
            $data['idImageBig'] = $Request->file('image')->path();
            }
            else
            {
            unset($data['idImageSmall']);
            unset($data['idImageMiddle']);
            unset($data['idImageBig']);
            }

            if(@$data['idPublicationCommentReferen'] == '') unset($data['idPublicationCommentReferen']);
            if(@$data['idUser'] == '') unset($data['idUser']);

        $status = $this->_PublicationCommentTreeArray->update($Request->input('idPublicationComment'), $data);

            if($status)
            {
                Log::info('Обновление комментария в публикации.',
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
                Log::warning('Неудачное обновление комментария в публикаци.',
                    [
                    'module' => "Publication",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_PublicationCommentTreeArray->getErrorType(),
                'errormsg' => $this->_PublicationCommentTreeArray->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление комментария в публикаци.',
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
     * @param \App\Modules\Publication\Http\Requests\PublicationCommentTreeAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PublicationCommentTreeAdminDestroyRequest $Request)
    {
    $status = $this->_PublicationCommentTreeArray->destroy($Request->input('idPublicationComment'));

        if($status == true && $this->_PublicationCommentTreeArray->hasError() == false)
        {
            Log::info('Удаление комментария в публикации.',
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
            Log::warning('Неудачное удаление комментария в публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PublicationCommentTreeArray->getErrorType(),
            'errormsg' => $this->_PublicationCommentTreeArray->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
