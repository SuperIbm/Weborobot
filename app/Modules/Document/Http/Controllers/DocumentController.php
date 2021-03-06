<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 * @package App.Modules.Document
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Document\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Util;
use Document;
use Storage;

use App\Modules\Document\Http\Requests\DocumentCreateRequest;
use App\Modules\Document\Http\Requests\DocumentUpdateRequest;
use App\Modules\Document\Http\Requests\DocumentDestroyRequest;

/**
 * Класс контроллер для документа.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentController extends Controller
{
	/**
	 * Получение байт кода документа.
	 * @param string $name Название документа.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
    public function read($name)
    {
    $pathinfo = pathinfo($name);

    $id = substr($pathinfo["basename"], 0, Util::strlen($pathinfo["basename"]) - Util::strlen($pathinfo["extension"]) - 1);
    $format = strtolower($pathinfo["extension"]);

    $document = Document::get($id);

	    if($document['format'] == $format)
	    {
		    if($format == "png") $format = 'document/png';
		    else if($format == "jpg") $format = 'document/jpeg';
		    else if($format == "gif") $format = 'document/gif';
		    else if($format == "swf") $format = 'document/application/x-shockwave-flash';

		    return (new Response(Document::getByte($id)))
		    ->header('Cache-Control', 'max-age=2592000')
		    ->header('Content-type', $format);
	    }
	    else return (new Response(null, 404));
    }


	/**
	 * Создание документа.
	 * @param \App\Modules\Document\Http\Requests\DocumentCreateRequest $Request Запрос.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function create(DocumentCreateRequest $Request)
	{
	$Request->file('file')->move(storage_path('app/public/documents/'), $Request->input('id').'.'.$Request->input('format'));
	return response()->json(['success' => true]);
	}


	/**
	 * Обновление документа.
	 * @param \App\Modules\Document\Http\Requests\DocumentUpdateRequest $Request Запрос.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function update(DocumentUpdateRequest $Request)
	{
	$Request->file('file')->move(storage_path('app/public/documents/'), $Request->input('id').'.'.$Request->input('format'));
	return response()->json(['success' => true]);
	}


	/**
	 * Удаление документа.
	 * @param \App\Modules\Document\Http\Requests\DocumentDestroyRequest $Request Запрос.
	 * @return \Illuminate\Http\Response Ответ.
	 * @version 1.0
	 * @since 1.0
	 */
	public function destroy(DocumentDestroyRequest $Request)
	{
	Storage::disk('documents')->delete($Request->input('id').'.'.$Request->input('format'));
	return response()->json(['success' => true]);
	}
}
