<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Http\Controllers;

use Image;
use Log;
use Auth;
use Illuminate\Routing\Controller;

use App\Modules\Publication\Repositories\PublicationComment;
use App\Modules\Publication\Http\Requests\PublicationCommentImageAdminReadRequest;
use App\Modules\Publication\Http\Requests\PublicationCommentImageAdminCreateRequest;
use App\Modules\Publication\Http\Requests\PublicationCommentImageAdminDestroyRequest;


/**
 * Класс контроллер для работы с изображениями комментариев в публикациях в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationCommentImageAdminController extends Controller
{
/**
 * Репозитарий комментариев.
 * @var \App\Modules\Publication\Repositories\PublicationComment
 * @version 1.0
 * @since 1.0
 */
private $_PublicationComment;

    /**
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\PublicationComment $PublicationComment Репозитарий комментариев.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PublicationComment $PublicationComment)
    {
    $this->_PublicationComment = $PublicationComment;
    }

    /**
     * Чтение данных.
     * @param \App\Modules\Publication\Http\Requests\PublicationCommentImageAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(PublicationCommentImageAdminReadRequest $Request)
    {
    $data = Image::get($Request->input('id'));

        if($data)
        {
            $data =
            [
            'data' => $data == null ? [] : [$data],
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
     * @param \App\Modules\Publication\Http\Requests\PublicationCommentImageAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(PublicationCommentImageAdminCreateRequest $Request)
    {
    $data = [];
    $data['idImageSmall'] = $Request->file('image')->path();
    $data['idImageMiddle'] = $Request->file('image')->path();
    $data['idImageBig'] = $Request->file('image')->path();

    $idPublicationComment = $this->_PublicationComment->update($Request->input("idPublicationComment"), $data);

        if($idPublicationComment)
        {
            Log::warning('Изменение изображения комментария публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => true,
            'data' => $this->_PublicationComment->get($Request->input("idPublicationComment"))
            ];
        }
        else
        {
            Log::warning('Неудачное изменение изображения комментария.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PublicationComment->getErrorType(),
            'errormsg' => $this->_PublicationComment->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Publication\Http\Requests\PublicationCommentImageAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PublicationCommentImageAdminDestroyRequest $Request)
    {
    $data = $this->_PublicationComment->get($Request->input('idPublicationComment'));

        if($data)
        {
        Image::destroy($data['idImageSmall']['idImage']);
        Image::destroy($data['idImageMiddle']['idImage']);
        Image::destroy($data['idImageBig']['idImage']);

            $status = $this->_PublicationComment->update($Request->input('idPublicationComment'),
                [
                'idImageSmall' => null,
                'idImageMiddle' => null,
                'idImageBig' => null
                ]
            );

            if($status == true && $this->_PublicationComment->hasError() == false)
            {
                Log::info('Удаление изображения комментария публикации.',
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
                Log::warning('Неудачное удаление изображения комментария публикации.',
                    [
                    'module' => "Publication",
                    'login' => Auth::getUser()->login,
                    'type' => 'destroy'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_PublicationComment->getErrorType(),
                'errormsg' => $this->_PublicationComment->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное удаление изображения публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }
}
