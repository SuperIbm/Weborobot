<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     br2nl<br>
 * Date:     Feb 26, 2003
 * Purpose:  convert <<br>> to \n
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|nl2br}
 * @link http://smarty.php.net/manual/en/language.modifier.br2nl.php
 *          br2nl (Smarty online manual)
 * @version  1.0
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_br2nl($string)
{
return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}

/* vim: set expandtab: */
?>
