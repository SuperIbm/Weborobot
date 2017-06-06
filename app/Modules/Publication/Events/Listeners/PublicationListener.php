<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Events\Listeners;

use Image;
use App\Modules\Publication\Models\PublicationEloquent as Publication;

/**
 * Класс обработчик событий для модели публикаций.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\Publication\Models\PublicationEloquent $Publication Модель для таблицы публикаций.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
 	 * @since 1.0
	 */
	public function creating(Publication $Publication)
	{
	$result = $Publication->newQuery()
	->where("link", $Publication->link)
	->where("idPublicationSection", $Publication->idPublicationSection)
	->first();

		if($result)
		{
        $Publication->addError('validate', 'Вы не можете добавить такой раздел, т.к. он уже есть в базе данных!', 'link');
		return false;
		}

	return true;
	}


    /**
     * Обработчик события при добавлении записи.
     * @param \App\Modules\Publication\Models\PublicationEloquent $Publication Модель для таблицы публикаций.
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
	public function updating(Publication $Publication)
	{
	$result = $Publication->newQuery()
	->where("idPublication", "!=", $Publication->idPublication)
	->where("link", $Publication->link)
	->where("idPublicationSection", $Publication->idPublicationSection)
	->first();

		if($result)
		{
        $Publication->addError('validate', 'Вы не можете добавить такой раздел, т.к. он уже есть в базе данных!', 'nameLink');
		return false;
		}

	return true;
	}


    /**
     * Обработчик события при удалении записи.
     * @param \App\Modules\Publication\Models\PublicationEloquent $Publication Модель для таблицы публикаций.
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
	public function deleting(Publication $Publication)
	{
        if($Publication->idImageSmall) Image::destroy($Publication->idImageSmall["idImage"]);
        if($Publication->idImageMiddle) Image::destroy($Publication->idImageMiddle["idImage"]);
        if($Publication->idImageBig) Image::destroy($Publication->idImageBig["idImage"]);

    $Publication->PublicationComment()->delete();
    $Publication->PublicationQueryWord()->delete();
    return true;
	}
}