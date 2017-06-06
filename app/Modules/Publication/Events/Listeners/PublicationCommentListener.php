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
use App\Modules\Publication\Models\PublicationCommentEloquent as PublicationComment;

/**
 * Класс обработчик событий для модели комментариев публикаций.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationCommentListener
{
    /**
     * Обработчик события при удалении записи.
     * @param \App\Modules\Publication\Models\PublicationCommentEloquent $PublicationComment Модель для таблицы разделов комментариев.
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
	public function deleting(PublicationComment $PublicationComment)
	{
        if($PublicationComment->idImageSmall) Image::destroy($PublicationComment->idImageSmall["idImage"]);
        if($PublicationComment->idImageMiddle) Image::destroy($PublicationComment->idImageMiddle["idImage"]);
        if($PublicationComment->idImageBig) Image::destroy($PublicationComment->idImageBig["idImage"]);

    $PublicationComment->Publication()->delete();
    return true;
	}
}