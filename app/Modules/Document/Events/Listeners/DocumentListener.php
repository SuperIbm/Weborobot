<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 * @package App.Modules.Document
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Document\Events\Listeners;

use App;
use Config;

/**
 * Класс обработчик событий для модели документов.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $Document Модель документов.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function created($Document)
	{
	return App::make('document.driver')->create($Document->idDocument, $Document->format, $Document->path);
	}


	/**
	 * Обработчик события при обновлении записи.
	 * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $Document Модель документов.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function updated($Document)
	{
	App::make('document.driver')->destroy($Document->getOriginal()['idDocument'], $Document->getOriginal()['format']);
	return App::make('document.driver')->update($Document->idDocument, $Document->format, $Document->path);
	}


	/**
	 * Обработчик события при чтении данных.
	 * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $Document Модель документов.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function readed($Document)
	{
	$Document->path = App::make('document.driver')->path($Document->idDocument, $Document->format);
	$Document->pathCache = $Document->path;
	$Document->byte = App::make('document.driver')->read($Document->idDocument, $Document->format);

		if($Document->cache) $Document->path .= "?".$Document->cache;

	$Document->pathSource = App::make('document.driver')->pathSource($Document->idDocument, $Document->format);

	return true;
	}


	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $Document Модель документов.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleted($Document)
	{
        if(!Config::get("document.softDeletes")) return App::make('document.driver')->destroy($Document->idDocument, $Document->format);
        else return true;
	}
}