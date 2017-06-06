<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Http\Controllers;

use Util;
use Log;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Publication\Repositories\Publication;
use App\Modules\Publication\Http\Requests\PublicationAdminReadRequest;
use App\Modules\Publication\Http\Requests\PublicationAdminDestroyRequest;
use App\Modules\Publication\Repositories\PublicationQueryWord;

/**
 * Класс контроллер для работы с публикациями в административной части.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PublicationAdminController extends Controller
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
     * Конструктор.
     * @param \App\Modules\Publication\Repositories\Publication $Publication Репозитарий публикаций.
     * @param \App\Modules\Publication\Repositories\PublicationQueryWord Репозитарий ключевых слов публикаций.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Publication $Publication, PublicationQueryWord $PublicationQueryWord)
    {
    $this->_Publication = $Publication;
    $this->_PublicationQueryWord = $PublicationQueryWord;
    }

    /**
     * Чтение данных.
     * @param \App\Modules\Publication\Http\Requests\PublicationAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(PublicationAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idPublication',
            'value' => $Request->input('id')
            ];

        $data = $this->_Publication->read($filters);
        }
        else
        {
        $filters = json_decode($Request->input('filter'), true);

            if($Request->input('idPublicationSection'))
            {
                $filters[] =
                [
                'property' => 'idPublicationSection',
                'value' => $Request->input('idPublicationSection')
                ];
            }

            $data = $this->_Publication->read
            (
            $filters,
            null,
            json_decode($Request->input('sort'), true),
            $Request->input('start'),
            $Request->input('limit'),
                [
                'PublicationSection'
                ]
            );
        }

        if($this->_Publication->hasError() == false)
        {
            if($data)
            {
                for($i = 0; $i < count($data); $i++)
                {
                    $publicationQueryWord = $this->_PublicationQueryWord->read
                    (
                        [
                            [
                            'property' => 'idPublication',
                            'value' => $data[$i]['idPublication']
                            ]
                        ]
                    );

                    if($publicationQueryWord) $data[$i]['queryWords'] = $publicationQueryWord;
                }
            }

            $data =
            [
            'data' => $data == null ? [] : $data,
            'total' => $this->_Publication->count($filters),
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


    /**
     * Добавление данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function create(Request $Request)
    {
    $data = $Request->all();
    $data['dateAdd'] = Carbon::createFromFormat('d.m.Y H:i', $data['dateAdd'].' '.$data['timeAdd']);

        if($Request->hasFile('image') && $Request->file('image')->isValid())
        {
        $data['idImageSmall'] = $Request->file('image')->path();
        $data['idImageMiddle'] = $Request->file('image')->path();
        $data['idImageBig'] = $Request->file('image')->path();
        }

    $idPublication = $this->_Publication->create($data);

        if($idPublication)
        {
        $queryWords = $Request->input('queryWords');

            if($queryWords)
            {
            $queryWords = explode(", ", $queryWords);

                for($i = 0; $i < count($queryWords); $i++)
                {
                $queryWords[$i] = trim(Util::toLower($queryWords[$i]));

                    $this->_PublicationQueryWord->create
                    (
                        [
                        'idPublication' => $idPublication,
                        'queryWord' => trim(Util::toLower($queryWords[$i]))
                        ]
                    );
                }
            }

            Log::info('Добавление публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => true
            ];
        }
        else
        {
            Log::warning('Неудачное добавления публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Publication->getErrorType(),
            'errormsg' => $this->_Publication->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Обновление данных.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function update(Request $Request)
    {
        if($Request->input('idPublication'))
        {
        $data = $Request->all();

            if(!strpos($data["dateAdd"], " "))
            {
            $dateAddAr = explode(" ", $data["dateAdd"]);
            $data["dateAdd"] = $dateAddAr[0];
            $data["dateAdd"] .= " ".$data["timeAdd"];
            $data['dateAdd'] = Carbon::createFromFormat('d.m.Y H:i', $data['dateAdd']);
            }
            else $data['dateAdd'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['dateAdd']);

            if($Request->hasFile('image') && $Request->file('image')->isValid())
            {
            $data['idImageSmall'] = $Request->file('image')->path();
            $data['idImageMiddle'] = $Request->file('image')->path();
            $data['idImageBig'] = $Request->file('image')->path();
            }
            else
            {
            unset($data['idImageSmall']);
            unset($data['idImageMiddle']);
            unset($data['idImageBig']);
            }

        $idPublication = $this->_Publication->update($Request->input('idPublication'), $data);

            if($idPublication)
            {
                if($Request->input('isDeleteQueryWords'))
                {
                    $queryWords = $this->_PublicationQueryWord->read
                    (
                        [
                            [
                            'property' => 'idPublication',
                            'value' => $idPublication
                            ]
                        ]
                    );

                    if($queryWords)
                    {
                        for($z = 0; $z < count($queryWords); $z++)
                        {
                        $this->_PublicationQueryWord->destroy($queryWords[$z]['idPublicationQueryWord']);
                        }
                    }

                $queryWords = $Request->input('queryWords');

                    if($queryWords)
                    {
                    $queryWords = explode(", ", $queryWords);

                        for($i = 0; $i < count($queryWords); $i++)
                        {
                        $queryWords[$i] = trim(Util::toLower($queryWords[$i]));

                            $this->_PublicationQueryWord->create
                            (
                                [
                                'idPublication' => $idPublication,
                                'queryWord' => trim(Util::toLower($queryWords[$i]))
                                ]
                            );
                        }
                    }
                }

                Log::info('Обновление публикации.',
                    [
                    'module' => "Publication",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => true
                ];
            }
            else
            {
                Log::warning('Неудачное обновление публикации.',
                    [
                    'module' => "Publication",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_Publication->getErrorType(),
                'errormsg' => $this->_Publication->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Publication->getErrorType(),
            'errormsg' => $this->_Publication->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\Publication\Http\Requests\PublicationAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PublicationAdminDestroyRequest $Request)
    {
    $status = $this->_Publication->destroy($Request->input('idPublication'));

        if($status == true && $this->_Publication->hasError() == false)
        {
            Log::info('Удаление обновления публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => true
            ];
        }
        else
        {
            Log::warning('Неудачное удаление публикации.',
                [
                'module' => "Publication",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_Publication->getErrorType(),
            'errormsg' => $this->_Publication->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
