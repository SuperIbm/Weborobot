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

use App\Modules\Publication\Repositories\Publication;
use App\Modules\Publication\Http\Requests\PublicationImageAdminReadRequest;
use App\Modules\Publication\Http\Requests\PublicationImageAdminCreateRequest;
use App\Modules\Publication\Http\Requests\PublicationImageAdminDestroyRequest;


/**
 * Класс контроллер для работы с изображениями в публикациях в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationImageAdminController extends Controller
{
/**
 * Репозитарий публикаций.
 * @var \App\Modules\Publication\Repositories\Publication
 * @version 1.0
 * @since 1.0
 */
private $_Publication;

    /**
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\Publication $Publication Репозитарий публикаций.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Publication $Publication)
    {
    $this->_Publication = $Publication;
    }

    /**
     * Чтение данных.
     * @param \App\Modules\Publication\Http\Requests\PublicationImageAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(PublicationImageAdminReadRequest $Request)
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
     * @param \App\Modules\Publication\Http\Requests\PublicationImageAdminCreateRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(PublicationImageAdminCreateRequest $Request)
    {
    $data = [];
    $data['idImageSmall'] = $Request->file('image')->path();
    $data['idImageMiddle'] = $Request->file('image')->path();
    $data['idImageBig'] = $Request->file('image')->path();

    $idPublication = $this->_Publication->update($Request->input("idPublication"), $data);

        if($idPublication)
        {
            Log::warning('Изменение изображения публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => true,
            'data' => $this->_Publication->get($Request->input("idPublication"))
            ];
        }
        else
        {
            Log::warning('Неудачное изменение изображения пользователя.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Publication->getErrorType(),
            'errormsg' => $this->_Publication->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Publication\Http\Requests\PublicationImageAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PublicationImageAdminDestroyRequest $Request)
    {
    $data = $this->_Publication->get($Request->input('idPublication'));

        if($data)
        {
        Image::destroy($data['idImageSmall']['idImage']);
        Image::destroy($data['idImageMiddle']['idImage']);
        Image::destroy($data['idImageBig']['idImage']);

            $status = $this->_Publication->update($Request->input('idPublication'),
                [
                'idImageSmall' => null,
                'idImageMiddle' => null,
                'idImageBig' => null
                ]
            );

            if($status == true && $this->_Publication->hasError() == false)
            {
                Log::info('Удаление изображения публикации.',
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
                Log::warning('Неудачное удаление изображения публикации.',
                    [
                    'module' => "Publication",
                    'login' => Auth::getUser()->login,
                    'type' => 'destroy'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Publication->getErrorType(),
                'errormsg' => $this->_Publication->getErrorMessage()
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
