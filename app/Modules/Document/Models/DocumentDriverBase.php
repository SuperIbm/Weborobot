<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 * @package App.Modules.Document
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Document\Models;

use App\Modules\Document\Contracts\DocumentDriver;
use Path;
use Document as DocumentRepository;
use File;


/**
 * Класс драйвер хранения документов в базе данных.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentDriverBase extends DocumentDriver
{
	/**
	 * Метод получения пути к документу.
	 * @param int $id Индификатор документа.
	 * @param string $format Формат документа.
	 * @return string Вернет путь к документу.
	 * @since 1.0
	 * @version 1.0
	 */
	public function path($id, $format)
	{
	return 'doc/read/'.$id.'.'.$format;
	}


	/**
	 * Метод получения физического пути к документу.
	 * @param int $id Индификатор документа.
	 * @param string $format Формат документа.
	 * @return string Вернет физический путь к документа.
	 * @since 1.0
	 * @version 1.0
	 */
	public function pathSource($id, $format)
	{
	return Path::getDomanName().$this->path($id, $format);
	}


	/**
	 * Метод чтения документа.
	 * @param int $id Индификатор документа.
	 * @param string $format Формат документа.
	 * @return string Вернет байт код документа.
	 * @since 1.0
	 * @version 1.0
	 */
	public function read($id, $format)
	{
	return DocumentRepository::getByte(pathinfo($id.'.'.$format, PATHINFO_FILENAME));
	}


	/**
	 * Метод создания документа.
	 * @param int $id Индификатор документа.
	 * @param string $path Путь к документу.
	 * @param string $format Формат документа.
	 * @return bool Вернет статус успешности создания документа.
	 * @since 1.0
	 * @version 1.0
	 */
	public function create($id, $format, $path)
	{
	return DocumentRepository::updateByte($id, File::get($path));
	}


	/**
	 * Метод обновления документа.
	 * @param int $id Индификатор документа.
	 * @param string $format Формат документа.
	 * @param string $path Путь к документу.
	 * @return bool Вернет статус успешности обновления документа.
	 * @since 1.0
	 * @version 1.0
	 */
	public function update($id, $format, $path)
	{
	return DocumentRepository::updateByte($id, File::get($path));
	}


	/**
	 * Метод удаления документа.
	 * @param int $id Индификатор документа.
	 * @param string $format Формат документа.
	 * @return bool Вернет статус успешности удаления документа.
	 * @since 1.0
	 * @version 1.0
	 */
	public function destroy($id, $format)
	{
	return true;
	}
}
?>