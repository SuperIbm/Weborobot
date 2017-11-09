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
use Carbon\Carbon;


/**
 * Класс декоратор для разбивки публикаций по годам.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationItemYear extends Decorator
{
/**
 * Репозитарий публикаций.
 * @var \App\Modules\Publication\Repositories\Publication
 * @version 1.0
 * @since 1.0
 */
private $_Publication;

/**
 * Текущий год просмотра.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $year;


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
    return "years";
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

        $data = $this->_Publication->read
        (
            $filters,
            true,
            [
                [
                "property" => "dateAdd",
                "direction" => "DESC"
                ],
                [
                "property" => "idPublication",
                "direction" => "ASC"
                ]
            ],
            0,
            null,
            [
            'PublicationQueryWord',
            'PublicationSection'
            ]
        );

        if($data)
        {
        $years = [];

            for($i = 0; $i < count($data); $i++)
            {
            $years[] = Carbon::createFromFormat("Y-m-d H:i:s", $data[$i]["dateAdd"])->year;
            }

        $years = array_unique($years);
        $this->year = $this->year ? $this->year : $years[0];
        $ParentDecorator->year = $this->year;
        $items = [];

            foreach($years as $key => $yr)
            {
                $items[] =
                [
                "item" => $yr,
                "current" => $yr == $this->year
                ];
            }

        $this->_setData($items);
        }

    return true;
    }
}