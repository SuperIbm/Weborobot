<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Util;
use Image;
use Storage;

use App\Modules\Image\Http\Requests\ImageCreateRequest;
use App\Modules\Image\Http\Requests\ImageUpdateRequest;
use App\Modules\Image\Http\Requests\ImageDestroyRequest;

/**
 * Класс контроллер для изображения.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageController extends Controller
{
	/**
	 * Получение байт кода изображения.
	 * @param string $name Название изображения.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
    public function read($name)
    {
    $pathinfo = pathinfo($name);

    $id = substr($pathinfo["basename"], 0, Util::strlen($pathinfo["basename"]) - Util::strlen($pathinfo["extension"]) - 1);
    $format = strtolower($pathinfo["extension"]);

    $image = Image::get($id);

	    if($image['format'] == $format)
	    {
        $format = null;

		    if($format == "png") $format = 'image/png';
		    else if($format == "jpg") $format = 'image/jpeg';
		    else if($format == "gif") $format = 'image/gif';
		    else if($format == "swf") $format = 'image/application/x-shockwave-flash';

		    if($format)
            {
            return (new Response(Image::getByte($id)))
            ->header('Cache-Control', 'max-age=2592000')
            ->header('Content-type', $format);
            }
	    }

    return (new Response(null, 404));
    }


	/**
	 * Создание изображения.
	 * @param \App\Modules\Image\Http\Requests\ImageCreateRequest $Request Запрос.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function create(ImageCreateRequest $Request)
	{
	$Request->file('file')->move(storage_path('app/public/images/'), $Request->input('id').'.'.$Request->input('format'));
	return response()->json(['success' => true]);
	}


	/**
	 * Обновление изображения.
	 * @param \App\Modules\Image\Http\Requests\ImageUpdateRequest $Request Запрос.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function update(ImageUpdateRequest $Request)
	{
	$Request->file('file')->move(storage_path('app/public/images/'), $Request->input('id').'.'.$Request->input('format'));
	return response()->json(['success' => true]);
	}


	/**
	 * Удаление изображения.
	 * @param \App\Modules\Image\Http\Requests\ImageDestroyRequest $Request Запрос.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function destroy(ImageDestroyRequest $Request)
	{
	Storage::disk('images')->delete($Request->input('id').'.'.$Request->input('format'));
	return response()->json(['success' => true]);
	}
}
