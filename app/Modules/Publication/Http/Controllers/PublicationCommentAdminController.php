<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Modules\Publication\Repositories\PublicationComment;
use App\Modules\Publication\Http\Requests\PublicationCommentAdminReadRequest;

/**
 * Класс контроллер для работы с комментариями в публикации в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationCommentAdminController extends Controller
{
/**
 * Репозитарий комментариев в публикации.
 * @var \App\Modules\Publication\Repositories\PublicationComment
 * @version 1.0
 * @since 1.0
 */
private $_PublicationComment;

    /**
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\PublicationComment $PublicationComment Репозитарий комментариев.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PublicationComment $PublicationComment)
    {
    $this->_PublicationComment = $PublicationComment;
    }

    /**
     * Чтение данных.
     * @param \App\Modules\Publication\Http\Requests\PublicationCommentAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(PublicationCommentAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idPublicationComment',
            'value' => $Request->input('id')
            ];

        $data = $this->_PublicationComment->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            $data = $this->_PublicationComment->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit')
            );
        }

        if($this->_PublicationComment->hasError() == false)
        {
            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_PublicationComment->count($filters),
            'success' => true
            ];
        }
        else
        {
            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }
}
