<?php
/**
 * Модуль Шаблоны для страниц.
 * Этот модуль содержит все классы для работы с шаблонами для страниц.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageTemplate\Events\Listeners;

use App\Modules\PageTemplate\Models\PageTemplateEloquent as PageTemplate;
use Image;

/**
 * Класс обработчик событий для модели шаблон страниц.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageTemplateListener
{
	/**
	 * Обработчик события при удалении записи.
	 * @param \App\Modules\PageTemplate\Models\PageTemplateEloquent $PageTemplate Модель для шаблонов страниц.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function deleting(PageTemplate $PageTemplate)
	{
	    if($PageTemplate->idImage) Image::destroy($PageTemplate->idImage["idImage"]);

	return true;
	}
}