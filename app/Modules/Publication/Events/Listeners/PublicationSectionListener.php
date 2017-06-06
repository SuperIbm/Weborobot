<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Events\Listeners;

use App\Modules\Publication\Models\PublicationSectionEloquent as PublicationSection;

/**
 * Класс обработчик событий для модели разделов публикаций.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationSectionListener
{
    /**
     * Обработчик события при удалении записи.
     * @param \App\Modules\Publication\Models\PublicationSectionEloquent $PublicationSection Модель для таблицы разделов публикаций.
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
	public function deleting(PublicationSection $PublicationSection)
	{
    $PublicationSection->Publication()->delete();
    return true;
	}
}