<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Repositories;

use DB;
use Cache;
use App\Models\RepositaryMongoDb;

/**
 * Класс репозитария изображений на основе MongoDb.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageMongoDb extends Image
{
use RepositaryMongoDb;

	/**
	 * Создание.
	 * @param string $path Путь к файлу.
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	public function create($path)
	{
	$pro = getImageSize($path);
	$Model = $this->newInstance();
    $Model->idImage = round((time() * 1000) + microtime(true));
	$Model->path = $path;
	$Model->width = $pro[0];
	$Model->height = $pro[1];
	$Model->format = $this->getFormatText($pro[2]);
	$status = $Model->save();

		if(!$status)
		{
		$this->addError($Model->getErrors());
		return false;
		}

	return $Model->idImage;
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
		$pro = getImageSize($path);

		$Model->path = $path;
		$Model->width = $pro[0];
		$Model->height = $pro[1];
		$Model->format = $this->getFormatText($pro[2]);
		$Model->cache = time();

		$status = $Model->save();

			if($Model->hasError() == true || $status == false)
			{
			$this->addError($Model->getErrors());
			return false;
			}
			else Cache::tags(['Image', 'ImageItem'])->forget($id);

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
	$status = DB::connection('mongodb')
	->collection($this->newInstance()->getTable())
	->where('idImage', $id)
	->update(['byte' => $byte]);

	Cache::tags(['Image', 'ImageItem'])->forget($id);

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
	$image = $this->_getById($id);

		if($image)
		{
		unset($image['byte']);
		return $image;
		}
		else
		{
			$data = Cache::tags(['Image', 'ImageItem'])->remember($id, $this->getCacheMinutes(),
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
	 * @return string Вернет байт код изображения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function getByte($id)
	{
	$image = $this->_getById($id);

		if($image) return $image['byte'];
		else
		{
		$image = DB::connection('mongodb')
        ->collection($this->newInstance()->getTable())
		->where('idImage', $id)
		->first();

			if($image) return $image['byte'];
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
		else Cache::tags(['Image', 'ImageItem'])->forget($id);

	return $status;
	}
}