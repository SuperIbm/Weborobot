<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 * @package App.Modules.Document
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Document\Repositories;

use DB;
use Cache;
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария документов на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentEloquent extends Document
{
use RepositaryEloquent;

	/**
	 * Создание.
	 * @param string $path Путь к файлу.
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	public function create($path)
	{
	$Model = $this->newInstance();
	$Model->path = $path;
	$Model->format = pathinfo($path)["extension"];
	$status = $Model->save();

		if(!$status)
		{
		$this->addError($Model->getErrors());
		return false;
		}

	return $Model->idDocument;
	}

	/**
	 * Обновление.
	 * @param int $id Id записи для обновления.
	 * @param string $path Путь к файлу.
	 * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	public function update($id, $path)
	{
	$Model = $this->newInstance()->find($id);

		if($Model)
		{
		$Model->path = $path;
		$Model->format = pathinfo($path)["extension"];
		$Model->cache = time();

		$status = $Model->save();

			if($Model->hasError() == true || $status == false)
			{
			$this->addError($Model->getErrors());
			return false;
			}
			else Cache::tags(['Document', 'DocumentItem'])->forget($id);

		return $id;
		}
		else return false;
	}

	/**
	 * Обновление байт кода картинки.
	 * @param int $id Id записи для обновления.
	 * @param string $byte Байт код картинки.
	 * @return bool Вернет булево значение успешности операции.
	 * @since 1.0
	 * @version 1.0
	 */
	public function updateByte($id, $byte)
	{
	$status = DB::table($this->newInstance()->getTable())
	->where('idDocument', $id)
	->update(['byte' => $byte]);

	Cache::tags(['Document', 'DocumentItem'])->forget($id);

	return $status;
	}

	/**
	 * Получить по первичному ключу.
	 * @param int $id Первичный ключ.
	 * @return array Массив данных.
	 * @since 1.0
	 * @version 1.0
	 */
	public function get($id)
	{
	$document = $this->_getById($id);

		if($document)
		{
		unset($document['byte']);
		return $document;
		}
		else
		{
			$data = Cache::tags(['Document', 'DocumentItem'])->remember($id, $this->getCacheMinutes(),
				function() use ($id)
				{
				$Model = $this->getModel()->find($id);

					if($Model)
					{
					$data = $Model->toArray();
					$data['path'] = $Model->path;
					$data['pathCache'] = $Model->pathCache;
					$data['pathSource'] = $Model->pathSource;

					$this->_setById($id, $data);

					unset($data['byte']);
					return $data;
					}

				else return null;
				}
			);

			if($data) return $data;
			else return null;
		}
	}

	/**
	 * Получение байт кода картинки.
	 * @param int $id Id записи для обновления.
	 * @return string Вернет байт код документа.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getByte($id)
	{
	$document = $this->_getById($id);

		if($document) return $document['byte'];
		else
		{
		$document = DB::table($this->newInstance()->getTable())
		->where('idDocument', $id)
		->first();

			if($document) return $document['byte'];
			else return false;
		}
	}

	/**
	 * Получение всех записей.
	 * @return array Массив данных.
	 * @since 1.0
	 * @version 1.0
	 */
	public function all()
	{
	return $this->newInstance()->all();
	}


	/**
	 * Удаление.
	 * @param int|array $id Id записи для удаления.
	 * @return bool Вернет булево значение успешности операции.
	 * @since 1.0
	 * @version 1.0
	 */
	public function destroy($id)
	{
	$Model = $this->newInstance();
	$status = $Model->destroy($id);

		if(!$status) $this->addError($Model->getErrors());
		else Cache::tags(['Document', 'DocumentItem'])->forget($id);

	return $status;
	}
}