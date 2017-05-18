<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {module} function plugin
 * Type:     function<br>
 * Name:     module<br>
 * Purpose:  запуск и отображение модуля
 *
 * @author Monte Ohrt <monte at ohrt dot com>
 * @link   http://www.smarty.net/manual/en/language.function.counter.php {counter}
 *         (Smarty online manual)
 *
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 *
 * @return string|null
 */
function smarty_function_module($params, $template)
{
	if(isset($params["name"]) && isset($params["controller"]) && isset($params["method"]) && $params["name"] != "" && $params["controller"] != "" && $params["method"] != "")
	{
	$Controller = app('App\Modules\\'.$params["name"].'\Http\Controllers\\'.$params["controller"]);
	$Request = request();

		foreach($params as $k => $v)
		{
		$Request->request->add([$k => $v]);
		}

	$Controller->$params["method"]($Request);
	}
}
