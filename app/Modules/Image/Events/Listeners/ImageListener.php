<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Events\Listeners;

use App;

/**
 * Класс обработчик событий для модели изображений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $Image Модель изображений.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function created($Image)
	{
	return App::make('image.driver')->create($Image->idImage, $Image->format, $Image->path);
	}


	/**
	 * Обработчик события при обновлении записи.
	 * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $Image Модель изображений.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function updated($Image)
	{
	App::make('document.driver')->destroy($Image->getOriginal()['idImage'], $Image->getOriginal()['format']);
	return App::make('image.driver')->update($Image->idImage, $Image->format, $Image->path);
	}


	/**
	 * Обработчик события при чтении данных.
	 * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $Image Модель изображений.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function readed($Image)
	{
	$Image->path = App::make('image.driver')->path($Image->idImage, $Image->format);
	$Image->pathCache = $Image->path;
	$Image->byte = App::make('image.driver')->read($Image->idImage, $Image->format);

		if($Image->cache) $Image->path .= "?".$Image->cache;

	$Image->pathSource = App::make('image.driver')->pathSource($Image->idImage, $Image->format);

	return true;
	}


	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $Image Модель изображений.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleted($Image)
	{
	return App::make('image.driver')->destroy($Image->idImage, $Image->format);
	}
}