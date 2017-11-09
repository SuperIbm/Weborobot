<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Publication\Decorators\PublicationItem;
use App\Modules\Publication\Decorators\PublicationItemPagination;
use App\Modules\Publication\Decorators\PublicationItemYear;

use App\Modules\Publication\Http\Requests\PublicationGetArchiveRequest;

/**
 * Класс контроллер для работы с публикациями.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationController extends Controller
{
/**
 * Декоратор публикаций.
 * @var \App\Modules\Publication\Decorators\PublicationItem
 * @version 1.0
 * @since 1.0
 */
private $_PublicationItem;

/**
 * Декоратор пагинации публикаций.
 * @var \App\Modules\Publication\Decorators\PublicationItemPagination
 * @version 1.0
 * @since 1.0
 */
private $_PublicationItemPagination;

/**
 * Декоратор разбивки публикаций по годам.
 * @var \App\Modules\Publication\Decorators\PublicationItemYear
 * @version 1.0
 * @since 1.0
 */
private $_PublicationItemYear;


    public function __construct(PublicationItem $PublicationItem, PublicationItemPagination $PublicationItemPagination, PublicationItemYear $PublicationItemYear)
    {
    $this->_PublicationItem = $PublicationItem;
    $this->_PublicationItemPagination = $PublicationItemPagination;
    $this->_PublicationItemYear = $PublicationItemYear;
    }

    /**
     * Получение архива.
     * @param \App\Modules\Publication\Http\Requests\PublicationGetArchiveRequest $Request Запрос.
     * @param int $year Год отображения.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function getArchive(PublicationGetArchiveRequest $Request, $year = null)
    {
        $data = $this->_PublicationItem->addDecorators
        (
            [
                $this->_PublicationItemYear
                ->setParams
                (
                    [
                    "year" => $year
                    ]
                ),
                $this->_PublicationItemPagination
                ->setParams
                (
                    [
                    "page" => $Request->input("page"),
                    "limit" => $Request->input("limit", 10),
                    ]
                )
            ]
        )
        ->setParams
        (
            [
            "idPublicationSection" => $Request->input("idPublicationSection"),
            "tag" => $Request->input("tag")
            ]
        )
        ->run();

        print_r($data);
    }
}
