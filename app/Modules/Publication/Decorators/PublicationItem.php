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
use App\Modules\Publication\Repositories\PublicationQueryWord;
use App\Modules\Publication\Repositories\PublicationCommentTreeString;
use App\Modules\Publication\Repositories\PublicationSection;
use View;
use Storage;
use DB;


/**
 * Класс декоратор для публикации.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationItem extends Decorator
{
/**
 * Репозитарий публикаций.
 * @var \App\Modules\Publication\Repositories\Publication
 * @version 1.0
 * @since 1.0
 */
private $_Publication;

/**
 * Репозитарий ключевых слов публикаций.
 * @var \App\Modules\Publication\Repositories\PublicationQueryWord
 * @version 1.0
 * @since 1.0
 */
private $_PublicationQueryWord;

/**
 * Репозитарий комментариев публикации.
 * @var \App\Modules\Publication\Repositories\PublicationCommentTreeString
 * @version 1.0
 * @since 1.0
 */
private $_PublicationCommentTreeString;

/**
 * Репозитарий разделов публикации.
 * @var \App\Modules\Publication\Repositories\PublicationSection
 * @version 1.0
 * @since 1.0
 */
private $_PublicationSection;

/**
 * ID секции публикации, которую нужно получить.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $idPublicationSection;

/**
 * ID публикации, которую нужно получить.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $idPublication;

/**
 * Ссылка на публикацию, которую нужно получить.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $link;

/**
 * Количество публикаций, которых нужно получить.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $limit;

/**
 * Получить публикации, которые содержат этот тэг.
 * @var string
 * @version 1.0
 * @since 1.0
 */
public $tag;

/**
 * Получить публикации по определенному году.
 * @var int
 * @version 1.0
 * @since 1.0
 */
public $year;


    /**
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\Publication $Publication Репозитарий публикаций.
     * @param \App\Modules\Publication\Repositories\PublicationQueryWord $PublicationQueryWord Репозитарий ключевых слов публикаций.
     * @param \App\Modules\Publication\Repositories\PublicationCommentTreeString $PublicationCommentTreeString Репозитарий комментариев публикации.
     * @param \App\Modules\Publication\Repositories\PublicationSection $PublicationSection Репозитарий разделов публикации.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Publication $Publication, PublicationQueryWord $PublicationQueryWord, PublicationCommentTreeString $PublicationCommentTreeString, PublicationSection $PublicationSection)
    {
    $this->_Publication = $Publication;
    $this->_PublicationQueryWord = $PublicationQueryWord;
    $this->_PublicationCommentTreeString = $PublicationCommentTreeString;
    $this->_PublicationSection = $PublicationSection;
    }

    /**
     * Метод получения индекса.
     * @see \App\Models\Decorator::getIndex
     */
    public function getIndex()
    {
    return "publication";
    }

    /**
     * Выполнение действия.
     * @see \App\Models\Decorator::_action
     */
    protected function _action()
    {

    return true;
    }

    /**
     * Получить фильтры.
     * @return array Массив готовых фильтров.
     * @since 1.0
     * @version 1.0
     */
    public function getFilter()
    {
    $filters = [];

        if($this->idPublicationSection)
        {
            $filters[] =
            [
            'property' => 'idPublicationSection',
            'value' => $this->idPublicationSection
            ];
        }

        if($this->tag)
        {
            $filters[] =
            [
            'property' => 'queryWord',
            'value' => $this->tag
            ];
        }

        if($this->year)
        {
            $filters[] =
            [
            'property' => DB::raw("DATE_FORMAT(dateAdd, '%Y')"),
            'value' => $this->year,
            'table' => 'publication'
            ];
        }

    return $filters;
    }


    /**
     * Событие после действия.
     */
    public function afterAction(Decorator $Decorator, $status)
    {
        if($status)
        {
        $filters = $this->getFilter();

            if($this->idPublication)
            {
                $filters[] =
                [
                'property' => 'idPublication',
                'value' => $this->idPublication
                ];
            }

            if($this->link)
            {
                $filters[] =
                [
                'property' => 'link',
                'value' => $this->link
                ];
            }

            $sorts =
            [
                [
                "property" => "dateAdd",
                "direction" => "DESC"
                ],
                [
                "property" => "idPublication",
                "direction" => "ASC"
                ]
            ];

            $data = $this->_Publication->read
            (
                $filters,
                true,
                $sorts,
                0,
                $this->limit ? $this->limit : null,
                [
                'PublicationQueryWord',
                'PublicationSection'
                ]
            );

            if($this->_Publication->hasError() == false)
            {
            $section = null;

                if($this->idPublicationSection)
                {
                    $section = $this->_PublicationSection->read
                    (
                        [
                            [
                            'property' => 'idPublicationSection',
                            'value' => $this->idPublicationSection
                            ]
                        ],
                        true
                    );
                }

                if($this->idPublication || $this->link)
                {
                    if($data[0])
                    {
                    $pathFile = $data[0]['idPublication'].'.tpl';

                        if(!Storage::disk('publications')->exists($pathFile)) Storage::disk('publications')->put($pathFile, $data[0]['idPublication']);

                    $data[0]["textOfArticle"] = View::make('publications.'.$data[0]['idPublication'])->render();

                        $data[0]["comments"] = $this->_PublicationCommentTreeString->read
                        (
                            [
                                [
                                'property' => 'idPublication',
                                'value' => $data[0]['idPublication']
                                ]
                            ],
                            true
                        );

                        $this->_setData
                        (
                            [
                            "item" => $data[0],
                            "section" => $section
                            ]
                        );
                    }
                }
                else
                {
                    $this->_setData
                    (
                        [
                        "items" => $data,
                        "section" => $section
                        ]
                    );
                }

            return true;
            }
            else
            {
            $this->addError($this->_Publication->getError());
            return false;
            }
        }
        else return false;
    }
}