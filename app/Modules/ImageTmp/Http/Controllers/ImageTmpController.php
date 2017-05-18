<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Http\Controllers;

use Auth;
use Log;
use Util;
use ImageTmp;
use Illuminate\Routing\Controller;

use App\Modules\ImageTmp\Http\Requests\ImageTmpReadRequest;
use App\Modules\ImageTmp\Http\Requests\ImageTmpCreateRequest;
use App\Modules\ImageTmp\Http\Requests\ImageTmpUpdateRequest;
use App\Modules\ImageTmp\Http\Requests\ImageTmpDestroyRequest;

/**
 * Класс контроллер для временных изображений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageTmpController extends Controller
{
    /**
     * Получение временных изображений.
     * @param \App\Modules\ImageTmp\Http\Requests\ImageTmpReadRequest $Request Запрос.
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function read(ImageTmpReadRequest $Request)
    {
    $data = ImageTmp::find(json_decode($Request->file('tags'), true));

        if($data)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => count($data),
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
     * Создание временного изображения.
     * @param \App\Modules\ImageTmp\Http\Requests\ImageTmpCreateRequest $Request Запрос.
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function create(ImageTmpCreateRequest $Request)
    {
    $status = ImageTmp::create($Request->file('file'), $Request->file('width'), $Request->file('height'), json_decode($Request->file('tags'), true), json_decode($Request->input('filters'), true));

        if($status)
        {
            Log::info('Добавление временного изображения.',
                [
                'module' => "ImageTmp",
                'login' => Auth::getUser() ? Auth::getUser()->login : null,
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
            Log::warning('Неудачное добавления временного изображения.',
                [
                'module' => "ImageTmp",
                'login' => Auth::getUser() ? Auth::getUser()->login : null,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => ImageTmp::getErrorType(),
            'errormsg' => ImageTmp::getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Обновление временного изображения.
     * @param \App\Modules\ImageTmp\Http\Requests\ImageTmpUpdateRequest $Request Запрос.
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function update(ImageTmpUpdateRequest $Request)
    {
    $status = ImageTmp::update($Request->file('update'), $Request->file('file'), $Request->file('width'), $Request->file('height'), json_decode($Request->file('tags'), true), json_decode($Request->input('filters'), true));

        if($status)
        {
            Log::info('Изменение временного изображения.',
                [
                'module' => "ImageTmp",
                'login' => Auth::getUser() ? Auth::getUser()->login : null,
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
            Log::warning('Неудачное изменение временного изображения.',
                [
                'module' => "ImageTmp",
                'login' => Auth::getUser() ? Auth::getUser()->login : null,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => ImageTmp::getErrorType(),
            'errormsg' => ImageTmp::getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление временного изображения.
     * @param \App\Modules\ImageTmp\Http\Requests\ImageTmpDestroyRequest $Request Запрос.
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function destroy(ImageTmpDestroyRequest $Request)
    {
    $status = ImageTmp::destroy($Request->input('id'));

        if($status == true && ImageTmp::hasError() == false)
        {
            Log::info('Удаление временного изображения.',
                [
                'module' => "ImageTmp",
                'login' => Auth::getUser() ? Auth::getUser()->login : null,
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
            Log::warning('Неудачное удаление временного изображения.',
                [
                'module' => "ImageTmp",
                'login' => Auth::getUser() ? Auth::getUser()->login : null,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => ImageTmp::getErrorType(),
            'errormsg' => ImageTmp::getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление старого временного изображения.
     * @param int $seconds Количество секунд после которых считается, что изображение устарело.
     * @version 1.0
     * @since 1.0
     */
    public function destroyOld($seconds = 86400)
    {
    $imagesTmp = ImageTmp::find(null, $seconds);

        if($imagesTmp)
        {
            for($i = 0; $i < count($imagesTmp); $i++)
            {
            ImageTmp::destroy($imagesTmp[$i]['idImageTmp']);
            }
        }
    }
}
