<?php
/**
 * Модуль Блоки страницы.
 * Этот модуль содержит все классы для работы с блокми страницы.
 * @package App.Modules.Block
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Block\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса блока.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Block extends Facade
{
	/**
	 * Получить зарегистрированное имя компонента.
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
	return 'block';
	}
}