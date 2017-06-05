<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Page\Http\Controllers;

use PageCurrent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Modules\Page\Repositories\PageTreeArray;

/**
 * Класс контроллер для страниц сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageController extends Controller
{
/**
 * Репозитарий страниц.
 * @var \App\Modules\Page\Repositories\PageTreeArray
 * @version 1.0
 * @since 1.0
 */
private $_Page;

    /**
     * Конструктор.
     * @param \App\Modules\Page\Repositories\PageTreeArray $Page Репозитарий страниц.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PageTreeArray $Page)
    {
    $this->_Page = $Page;
    }


    /**
     * Чтение данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\Http\Response
     * @since 1.0
     * @version 1.0
     */
    public function read(Request $Request)
    {
    $html = PageCurrent::render($Request->url());

        if($html !== false) return (new Response($html, PageCurrent::getStatus()));
        else abort('404', 'Запрашиваемая вами страница не была найдена.');
    }
}
