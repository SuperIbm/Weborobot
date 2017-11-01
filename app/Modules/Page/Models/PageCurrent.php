<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Models;

use Exception;
use Route;
use Storage;
use Block;
use Util;
use Config;
use App\Modules\Page\Repositories\Page;
use App\Modules\PageTemplate\Repositories\PageTemplate;


/**
 * Класс для работы с текущей страницы, которую просматривает пользователь.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageCurrent
{
/**
 * Репозитарий страниц.
 * @var \App\Modules\Page\Repositories\Page
 * @version 1.0
 * @since 1.0
 */
private $_Page;

/**
 * Репозитарий шаблона страницы.
 * @var \App\Modules\PageTemplate\Repositories\PageTemplate
 * @version 1.0
 * @since 1.0
 */
private $_PageTemplate;

/**
 * Заголовок страницы.
 * @var string
 * @version 1.0
 * @since 1.0
 */
private $_title;

/**
 * Описание страницы.
 * @var string
 * @version 1.0
 * @since 1.0
 */
private $_description;

/**
 * Ключевые слова.
 * @var string
 * @version 1.0
 * @since 1.0
 */
private $_keywords;

/**
 * Текущий шаблон страницы.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private $_template;

/**
 * Данные текущей страницы.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private $_page;

/**
 * Контент основной части.
 * @var string
 * @version 1.0
 * @since 1.0
 */
private $_content;

/**
 * Массив отрендеренных данных блоков страницы.
 * @var array
 * @version 1.0
 * @since 1.0
 */
private $_blocks = [];

/**
 * HTML всей страницы.
 * @var string
 * @version 1.0
 * @since 1.0
 */
private $_html;

/**
 * Текущий HTTP статус для страницы.
 * @var int
 * @version 1.0
 * @since 1.0
 */
private $_status = 200;


    /**
     * Конструктор.
     * @param \App\Modules\Page\Repositories\Page $Page Репозитарий страниц.
     * @param \App\Modules\PageTemplate\Repositories\PageTemplate $PageTemplate Репозитарий шаблонов страницы.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Page $Page, PageTemplate $PageTemplate)
    {
    $this->_Page = $Page;
    $this->_PageTemplate = $PageTemplate;
    }

    /**
     * Установить данных текущей страницы.
     * @param array $page Данные текущей страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    protected function _setPage($page)
    {
    $this->_page = $page;
    return $this;
    }

    /**
     * Получить заголовок страницы.
     * @return array Данные текущей страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getPage()
    {
    return $this->_page;
    }

    /**
     * Установить заголовок страницы.
     * @param string $title Заголовок страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setTitle($title)
    {
    $this->_title = $title;
    return $this;
    }

    /**
     * Получить заголовок страницы.
     * @return string Заголовок страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getTitle()
    {
    return $this->_title;
    }

    /**
     * Установить описание страницы.
     * @param string $description Описание страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setDescription($description)
    {
    $this->_description = $description;
    return $this;
    }

    /**
     * Получить описание страницы.
     * @return string Описание страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getDescription()
    {
    return $this->_description;
    }

    /**
     * Установить ключевые слова страницы.
     * @param string $keywords Ключевые слова страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setKeywords($keywords)
    {
    $this->_keywords = $keywords;
    return $this;
    }

    /**
     * Получить ключевые слова страницы.
     * @return string Ключевые слова страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getKeywords()
    {
    return $this->_keywords;
    }

    /**
     * Устанавливаем текущий шаблон страницы.
     * @param array $template Массив данных шаблона страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setTemplate($template)
    {
    $this->_template = $template;
    return $this;
    }

    /**
     * Получение текущиго шаблона страницы.
     * @return array Массив данных шаблона страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getTemplate()
    {
    return $this->_template;
    }

    /**
     * Добавление HTML к блоку по его номеру.
     * @param int $number Номер блока.
     * @param string $html HTML для блока.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    protected function _addBlock($number, $html)
    {
        if(!isset($this->_blocks[$number])) $this->_blocks[$number] = "";

    $this->_blocks[$number] .=  $html;
    return $this;
    }

    /**
     * Получение всех блоков.
     * @return array Массив блоков с их HTML.
     * @since 1.0
     * @version 1.0
     */
    public function getBlocks()
    {
    return $this->_blocks;
    }

    /**
     * Получение HTML блока по его номеру.
     * @param int $number Номер блока.
     * @return string HTML блока.
     * @since 1.0
     * @version 1.0
     */
    public function getBlock($number)
    {
        if(isset($this->_blocks[$number])) return $this->_blocks[$number];
        else return null;
    }

    /**
     * Установка текущего HTTP статуса.
     * @param int $status Статус.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    protected function _setStatus($status)
    {
    $this->_status = $status;
    return $this;
    }

    /**
     * Получение текущего HTTP статуса.
     * @return int Текущий статус.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function getStatus()
    {
    return $this->_status;
    }

    /**
     * Установка контента основной части страницы.
     * @param string $content HTML контент основной части страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    protected function _setContent($content)
    {
    $this->_content = $content;
    return $this;
    }

    /**
     * Получение контента основной части страницы.
     * @return string HTML контент основной части страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function getContent()
    {
    return $this->_content;
    }

    /**
     * Установка HTML всей страницы.
     * @param string $html HTML контент всей страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    protected function _setHtml($html)
    {
    $this->_html = $html;
    return $this;
    }

    /**
     * Получение HTML контента всей страницы.
     * @return string HTML контент всей страницы.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function getHtml()
    {
    return $this->_content;
    }

    /**
     * Рендеринг и получение страницы.
     * @param string $path Путь к странице, которую нужно отрендерить.
     * @param array $params Параметры полученные с ссылки.
     * @return string|bool Вернет HTML всей страницы.
     * @throws Exception
     * @since 1.0
     * @version 1.0
     */
    public function render($path, $params = [])
    {
    $url = parse_url($path);

        if(isset($url['path']))
        {
            if(substr($url['path'], 0, 1) == '/') $url['path'] = substr($url['path'], 1, strlen($url['path']));
            if(substr($url['path'], Util::strlen($url['path']) - 1, Util::strlen($url['path'])) != '/') $url['path'] .= '/';

        $page = $this->_Page->getByDirname($url['path'], true, true);
        }
        else $page = $this->_Page->getByDirname('');

        if($page)
        {
        $this->_setPage($page);

            if($page['redirect'] != "")
            {
            $Response = redirect($page['redirect']);
            $Response = Route::prepareResponse(request(), $Response);
            $Response->sendHeaders();
            $this->_setStatus($Response->getStatusCode());
            return "";
            }
            else
            {
            $this->setTitle($page['title']);
            $this->setDescription($page['description']);
            $this->setKeywords($page['keywords']);

            $pageTemplate = $this->_PageTemplate->get($page['idPageTemplate'], true);

                if($pageTemplate)
                {
                $this->setTemplate($pageTemplate);
                $blocks = Block::render($path, $params);
                $this->_setStatus(Block::getStatus());

                    if($blocks)
                    {
                        foreach($blocks as $number => $html)
                        {
                        $this->_addBlock($number, $html);
                        }
                    }

                $pathFile = $page['idPage'].'.tpl';

                    if(!Storage::disk('pages')->exists($pathFile)) Storage::disk('pages')->put($pathFile, $page['html']);

                $this->_setContent(view('pages.'.$page['idPage'])->render());

                    $html = view('app.'.$pageTemplate['nameTemplate'].'.tpl.template',
                        [
                        'CONTENT' => $this->getContent(),
                        'BLOCKS' => $this->getBlocks(),
                        'TITLE' => $this->getTitle(),
                        'KEYWORDS' => $this->getKeywords(),
                        'DESCRIPTION' => $this->getDescription(),
                        'DOMAIN_NAME' => Config::get('app.url')
                        ]
                    )->render();

                $this->_setHtml($html);
                return $html;
                }
                else throw new Exception('Для запрашиваемой страницы '.$path.' не найден шаблон.');
            }
        }
        else return false;
    }
}