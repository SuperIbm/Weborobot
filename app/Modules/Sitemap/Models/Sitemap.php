<?php
/**
 * Модуль Sitemap.
 * Этот модуль содержит все классы для работы с sitemap.
 * @package App.Modules.Sitemap
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Sitemap\Models;

use Yangqi\Htmldom\Htmldom;
use Config;
use File;

/**
 * Класс для генерации sitemap.xml.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Sitemap
{
/**
 * Отсканированные страницы сайта.
 * @var array
 * @since 1.0
 * @version 1.0
 */
private $_pages = Array();

/**
 * Градация приоритета.
 * @var int
 * @since 1.0
 * @version 1.0
 */
private $_priority = 0.2;

    /**
     * Сканирование сайта и генерация sitemap.xml.
     * @param string $linkFull Полная ссылка к странице.
     * @param string $namePage Название страницы.
     * @param string $basePath Раздел с которого нужно начать сканирование.
     * @param string|array $basePathAllow Раздел, который может быть отсканирован.
     * @param string|array $basePathDisallow Раздел, который не может быть отсканирован.
     * @param callback $callback Функция, которая будет вызвана каждый раз при сканировании.
     * @return \App\Modules\Sitemap\Models\Sitemap Верент объект сконирования сайт и генерации sitemap.xml.
     * @since 1.0
     * @version 1.0
     */
    private function _scan($linkFull = null, $namePage = "Главная", $basePath = null, $basePathAllow = null, $basePathDisallow = null, $callback = null)
    {
    $domanName = Config::get("app.url");

        if($linkFull == null && $basePath == null) $linkFull = $domanName;
        else if($linkFull == null && $basePath != null) $linkFull = $domanName.$basePath;

    $linkShort = preg_replace("/".str_replace("/", "\/", $domanName)."/i", "", $linkFull);
    $linkShort = $linkShort == "" ? null : $linkShort;

    $isAllow = $this->_pathAllow($linkShort, $basePathAllow, $basePathDisallow);

        if($isAllow)
        {
        $linkFullSave = $linkFull;

            if(isset($this->_pages[$linkFullSave]) == false)
            {
            $parsUrl = parse_url($linkFull);

                if(@$parsUrl["query"] == "") $linkFull .= "?";
                else $linkFull .= "&";

            $linkFull .= "scan=1";
            $html = @file_get_contents($linkFull);

                if($html)
                {
                    if($callback) $callback($linkFull, $html);

                /* Попробуем убрать все <noindex>...</noindex>, <script>...</script> и <noscan>...</noscan> */
                $html = preg_replace('/<(noindex|script|noscan)[^>]*>(.*?)<\/(noindex|script|noscan)>/ixs', "", $html);

                $Htmldom = new Htmldom();
                $Htmldom->load($html, true, true);

                $arrLinks = Array();

                    foreach($Htmldom->find('a') as $A)
                    {
                        if($A->href)
                        {
                            $arrLinks[] = array
                            (
                            trim($A->href),
                            trim($A->innertext)
                            );
                        }
                    }

                    foreach($Htmldom->find('title') as $A)
                    {
                    $namePage = trim($A->innertext);
                    break;
                    }

                $priority = 1 - ((count(explode("/", $linkShort)) - 1) * $this->getPriority());

                    if($priority <= 0) $priority = 0.1;

                    $this->_pages[$linkFullSave] = array
                    (
                    "namePage" => $namePage,
                    "link" => $linkFullSave,
                    "date" => date("Y-m-d\TH:i:sP"),
                    "priority" => $priority
                    );

                    // Перейдем по найденным ссылкам
                    if($arrLinks)
                    {
                        for($i = 0; $i < count($arrLinks); $i++)
                        {
                        $urlParts = @parse_url($arrLinks[$i][0]);

                            if(!@$urlParts["scheme"]) $arrLinks[$i][0] = $domanName.$arrLinks[$i][0];
                            else
                            {
                            $how = preg_match("/".str_replace("/", "\/", $domanName)."/i", $arrLinks[$i][0]);

                                if($how == 0) continue;
                            }

                            if(preg_match("/".str_replace("/", "\/", $domanName)."[\w\/_]*(img|image|doc|js|admin|uploaded)\//i", $arrLinks[$i][0])) continue;
                            if(preg_match("/".str_replace("/", "\/", $domanName)."[\w\/_]*(\.(jpg|jpeg|png|gif|swf|flv|doc|docx|xls|xlsx|zip|rar))/i", $arrLinks[$i][0])) continue;
                            if(stripos($arrLinks[$i][0], "mailto:") === true) continue;

                        $urlParts = @parse_url($arrLinks[$i][0]);
                        $urlParts["query"] = @$urlParts["query"] == "" ? "" : "?".@$urlParts["query"];
                        $arrLinks[$i][0] = $urlParts["scheme"]."://".@$urlParts["host"].@$urlParts["path"].$urlParts["query"];

                        $this->_scan($arrLinks[$i][0], $arrLinks[$i][1], $basePath, $basePathAllow, $basePathDisallow, $callback);
                        }
                    }
                }
            }
        }

    return $this;
    }


    /**
     * Сканирование сайта и генерация sitemap.xml.
     * @param string $basePath Раздел с которого нужно начать сканирование.
     * @param string|array $basePathAllow Раздел, который может быть отсканирован.
     * @param string|array $basePathDisallow Раздел, который не может быть отсканирован.
     * @param callback $callback Функция, которая будет вызвана каждый раз при сканировании.
     * @return array Вернет массив всех отсканированных страниц.
     * @since 1.0
     * @version 1.0
     */
    public function scan($basePath = null, $basePathAllow = null, $basePathDisallow = null, $callback = null)
    {
    $this->_scan(null, null, $basePath, $basePathAllow, $basePathDisallow, $callback);
    return $this->_pages;
    }


    /**
     * Проверяем входит ли этот путь в пул доступных путей.
     * @param string $linkShort Путь, который нужно проверить.
     * @param string|array $basePathAllow Допустимый раздел для сканирования, можно указать массив путей.
     * @param string|array $basePathDisallow Не допустимый раздел для сканирования, можно указать массив путей.
     * @return bool Вернет true, если этот путь входит в пул допустимых путей.
     * @since 1.0
     * @version 1.0
     */
    private function _pathAllow($linkShort, $basePathAllow, $basePathDisallow)
    {
        if($basePathAllow)
        {
            if(is_string($basePathAllow)) if(strrpos($linkShort, $basePathAllow) === false) return false;
            else if(is_array($basePathAllow))
            {
            $found = false;

                for($i = 0; $i < count($basePathAllow); $i++)
                {
                    if(strrpos($linkShort, trim($basePathAllow[$i])) !== false)
                    {
                    $found = true;
                    break;
                    }
                }

                if($found == false) return false;
                else return true;
            }
        }

        if($basePathDisallow)
        {
            if(is_string($basePathDisallow)) if(strrpos($linkShort, $basePathDisallow) !== false) return false;
            else if(is_array($basePathDisallow))
            {
            $found = false;

                for($i = 0; $i < count($basePathDisallow); $i++)
                {
                    if(strrpos($linkShort, trim($basePathDisallow[$i])) !== false)
                    {
                    $found = true;
                    break;
                    }
                }

            if($found == true) return false;
            else return true;
            }
        }

    return true;
    }

    /**
     * Установка градации приоритета.
     * @param int $priority Число градации приоритета.
     * @return \App\Modules\Sitemap\Models\Sitemap Верент объект сконирования сайт и генерации sitemap.xml.
     * @since 1.0
     * @version 1.0
     */
    public function setPriority($priority)
    {
    $this->_priority = $priority;
    return $this;
    }


    /**
     * Получение градации приоритета.
     * @return int Градация приоритета.
     * @since 1.0
     * @version 1.0
     */
    public function getPriority()
    {
    return $this->_priority;
    }
}