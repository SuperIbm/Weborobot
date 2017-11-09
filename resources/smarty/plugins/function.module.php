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
	$oldParams = $Request->input();

        $Reflection = new ReflectionMethod($Controller, $params["method"]);

            foreach($Reflection->getParameters() as $key => $parameter)
            {
                if($parameter->getClass() && $parameter->getClass()->newInstance() instanceof \Illuminate\Http\Request)
                {
                $Request = $parameter->getClass()->newInstance();
                $Request->setContainer(App::getInstance());
                }
            }

    $params = array_merge($oldParams, $params);
    $Request->query->add($params);
    $Request->validate();

    $method = $params["method"];
    $prm = \PageCurrent::getParams();
	$Controller->$method($Request, ... $prm);
	}
}
