<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Events\Listeners;

use App\Modules\ImageTmp\Models\ImageTmpEloquent as ImageTmp;
use Image;

/**
 * Класс обработчик событий для модели временных изображений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageTmpListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\ImageTmp\Models\ImageTmpEloquent $ImageTmp Модель для таблицы временных изображений.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(ImageTmp $ImageTmp)
	{
	    if($ImageTmp->idImageSource) Image::destroy($ImageTmp->idImageSource["idImage"]);
        if($ImageTmp->idImageThumbnail) Image::destroy($ImageTmp->idImageThumbnail["idImage"]);

	return true;
	}
}