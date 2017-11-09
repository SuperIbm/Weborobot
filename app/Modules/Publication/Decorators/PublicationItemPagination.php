<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Decorators;

use App\Models\Decorator;
use App\Modules\Publication\Repositories\Publication;
use Request;
use Illuminate\Pagination\LengthAwarePaginator;


/**
 * Декоратор получения пагинации для публикаций.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationItemPagination extends Decorator
{
/**
 * Репозитарий публикаций.
 * @var \App\Modules\Publication\Repositories\Publication
 * @version 1.0
 * @since 1.0
 */
private $_Publication;


/**
 * Номер страницы.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $page = 1;

/**
 * Количество публикаций, которых нужно получить.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $limit = 10;

/**
 * Отступ.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $indent = 6;

/**
 * Выводить в виде готового HTML.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $html = true;


    /**
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\Publication $Publication Репозитарий публикаций.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Publication $Publication)
    {
    $this->_Publication = $Publication;
    }

    /**
     * Метод получения индекса.
     * @see \App\Models\Decorator::getIndex
     */
    public function getIndex()
    {
    return "pagination";
    }

    /**
     * Выполнение действия.
     * @see \App\Models\Decorator::_action
     */
    protected function _action()
    {
    /**
     * @var $ParentDecorator \App\Modules\Publication\Decorators\PublicationItem
     */
    $ParentDecorator = $this->getParentDecorator();
    $filters = $ParentDecorator->getFilter();

        $total = $this->_Publication->count
        (
            $filters,
            true,
            [
            'PublicationQueryWord',
            'PublicationSection'
            ]
        );

    $ParentDecorator->limit = $this->limit;
    $LengthAwarePaginator = new LengthAwarePaginator([], $total, $this->limit, $this->page);
    $LengthAwarePaginator->setPath(Request::url()."/");

        if($this->html == true) $this->_setData($LengthAwarePaginator->links());
        else $this->_setData($LengthAwarePaginator->toArray());

    return true;
    }
}