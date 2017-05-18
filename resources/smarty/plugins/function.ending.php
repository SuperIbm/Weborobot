<?php
/**
 * Smarty plugin
 *
 * @package    Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {ending} function plugin
 * Type:     function<br>
 * Name:     ending<br>
 * Date:     Feb 17, 2016<br>
 * Purpose:  Позволяет сколнять слова в зависимости от числа перед которым оно должно стоять<br>
 * Params:
 * <pre>
 * - number     - число.
 * - root       - корень слова.
 * - end_0      - первое окончание.
 * - end_1      - второе окончание.
 * - end_2      - третье окончание.
 * - end_3      - четвертое окончание.
 * - end_4      - пятое окончание.
 * - limit_0    - первый лими.
 * - limit_1    - второй лимит.
 * - limit_2    - третий лимит.
 * - limit_3    - четвертый лимит.
 * - limit_3    - пятый лимит.
 * Лимиты назначаются таким образом: 1-5 или 1, где первое число до тире, это минимальная длина и второе число, это максимальная длина лимита для окончания.
 * </pre>
 * Examples:
 * <pre>
 * {table num=3 root=товар end_0="" end_1="а" end_2="ов"}
 * </pre>
 *
 *
 * @param array $params parameters
 *
 * @return string
 */
function smarty_function_ending($params)
{
$params["number"] = intval($params["number"]);

$end = Array();

    if(isset($params["end_0"])) $end[] = $params["end_0"];
    if(isset($params["end_1"])) $end[] = $params["end_1"];
    if(isset($params["end_2"])) $end[] = $params["end_2"];
    if(isset($params["end_3"])) $end[] = $params["end_3"];
    if(isset($params["end_4"])) $end[] = $params["end_4"];

$limit = Array();

    if(isset($params["limit_0"])) $limit[] = $params["limit_0"];
    if(isset($params["limit_1"])) $limit[] = $params["limit_1"];
    if(isset($params["limit_2"])) $limit[] = $params["limit_2"];
    if(isset($params["limit_3"])) $limit[] = $params["limit_3"];
    if(isset($params["limit_4"])) $limit[] = $params["limit_4"];

    for($i = (count($limit) - 1); $i >= 0; $i--)
    {
    $limit[$i] = explode("-", $limit[$i]);

        if($limit[$i])
        {
            if(isset($limit[$i][0])) $limit[$i][0] = intval($limit[$i][0]);
            if(isset($limit[$i][1])) $limit[$i][1] = intval($limit[$i][1]);

            if($params["number"] >= $limit[$i][0] && !isset($limit[$i][1]))return $params["root"].$end[$i];
            else if(($params["number"] >= $limit[$i][0] && isset($limit[$i][1])) && ($params["number"] <= $limit[$i][1])) return $params["root"].$end[$i];
        }
    }

return $params["root"];
}