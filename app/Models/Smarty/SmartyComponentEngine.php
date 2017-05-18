<?php
/**
 * Шаблонизатор Smarty.
 * Этот пакет содержит классы для расширения шаблонизатора Smarty.
 * @package App.Models.Smarty
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Smarty;

use Latrell\Smarty\SmartyEngine;
use Util;

/**
 * Класс расширение для шаблонизирования по средставм компонентов шаблонизатором Smarty.
 * Данный класс позволяет производить получение шаблонов и их шаблонизирование, шаблоны которые получаеются через ComponentTemplate.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SmartyComponentEngine extends SmartyEngine
{
	/**
	 * Получение результатов шаблонизирования.
	 * @param string $path Путь к шаблону.
	 * @param array $data Данные для шаблонизирования.
	 * @return string результат шаблонизирования.
	 * @since 1.0
	 * @version 1.0
	 */
	public function get($path, array $data = array())
	{
	$id = substr($path, 0, Util::strlen($path) - 6);

	$this->Smarty->registerResource("component", new SmartyResourceComponentTemplate());
	return $this->evaluatePath('component:'.$id, $data);
	}
}