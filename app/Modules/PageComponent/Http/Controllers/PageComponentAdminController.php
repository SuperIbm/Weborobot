<?php
/**
 * Модуль Компонента страницы.
 * Этот модуль содержит все классы для работы с компонентами страницы.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponent\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\PageComponent\Repositories\PageComponent;
use App\Modules\PageComponent\Repositories\PageComponentTreeArray;
use App\Modules\PageTemplate\Repositories\PageTemplate;
use App\Modules\PageComponentSetting\Repositories\PageComponentSetting;
use App\Modules\Page\Repositories\Page;
use App\Modules\Module\Repositories\Module;

use App\Modules\PageComponent\Http\Requests\PageComponentAdminDestroyRequest;
use App\Modules\PageComponent\Http\Requests\PageComponentAdminWeightRequest;

/**
 * Класс контроллер для компонентов страниц.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageComponentAdminController extends Controller
{
/**
 * Репозитарий компонентов страницы.
 * @var \App\Modules\PageComponent\Repositories\PageComponent
 * @version 1.0
 * @since 1.0
 */
private $_PageComponent;

/**
 * Репозитарий компонентов страницы.
 * @var \App\Modules\PageComponent\Repositories\PageComponentTreeArray
 * @version 1.0
 * @since 1.0
 */
private $_PageComponentTreeArray;

/**
 * Репозитарий настроек компонентов.
 * @var \App\Modules\PageComponentSetting\Repositories\PageComponentSetting
 * @version 1.0
 * @since 1.0
 */
private $_PageComponentSetting;

/**
 * Репозитарий страниц.
 * @var \App\Modules\Page\Repositories\Page
 * @version 1.0
 * @since 1.0
 */
private $_Page;

/**
 * Репозитарий шаблонов страницы.
 * @var \App\Modules\PageTemplate\Repositories\PageTemplate
 * @version 1.0
 * @since 1.0
 */
private $_PageTemplate;

/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

    /**
     * Конструктор.
     * @param \App\Modules\PageComponent\Repositories\PageComponent $PageComponent Репозитарий компонентов страницы.
     * @param \App\Modules\PageComponent\Repositories\PageComponentTreeArray $PageComponentTreeArray Репозитарий компонентов страницы в виде древовидной структуры.
     * @param \App\Modules\PageComponentSetting\Repositories\PageComponentSetting $PageComponentSetting Репозитарий настроек компонентов.
     * @param \App\Modules\Page\Repositories\Page $Page Репозитарий страниц.
     * @param \App\Modules\PageTemplate\Repositories\PageTemplate $PageTemplate Репозитарий шаблонов страницы.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PageComponent $PageComponent, PageComponentTreeArray $PageComponentTreeArray, PageComponentSetting $PageComponentSetting, Page $Page, PageTemplate $PageTemplate, Module $Module)
    {
    $this->_PageComponent = $PageComponent;
    $this->_PageComponentTreeArray = $PageComponentTreeArray;
    $this->_PageComponentSetting = $PageComponentSetting;
    $this->_Page = $Page;
    $this->_PageTemplate = $PageTemplate;
    $this->_Module = $Module;
    }


    /**
     * Древовидная струткра модулей.
     * @param Request $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function tree(Request $Request)
    {
    $data = [];

        $page = $this->_Page->read
        (
            [
                [
                'property' => 'idPage',
                'value' => $Request->input('idPage')
                ]
            ],
            null,
            null,
            null,
            null,
            true
        );

        if($page)
        {
            $pageTemplate = $this->_PageTemplate->read
            (
                [
                    [
                    'property' => 'idPageTemplate',
                    'value' => $page[0]['idPageTemplate']
                    ]
                ]
            );

            if($pageTemplate)
            {
                for($i = 1, $z = 0; $i <= $pageTemplate[0]['countBlocks']; $i++, $z++)
                {
                    $data[$z] =
                    [
                    'id' => 'id_'.$i,
                    'text' => $i.' блок страницы',
                    'expanded' => true,
                    'leaf' => false,
                    'allowDrag' => false,
                    'icon' => 'engine/app/Modules/Page/admin/images/icon_Block_small.png',
                    'allowDrop' => true,
                    'idPage' => $Request->input('idPage'),
                    'children' => []
                    ];

                    $pageComponents = $this->_PageComponent->read
                    (
                        [
                            [
                            'property' => 'idPage',
                            'value' => $Request->input('idPage')
                            ],
                            [
                            'property' => 'numberBlock',
                            'value' => $i
                            ]
                        ],
                        [
                            [
                            'property' => 'weight',
                            'direction' => 'asc'
                            ]
                        ],
                        null,
                        null,
                        [
                        'Component'
                        ]
                    );

                    if($pageComponents)
                    {
                        for($y = 0; $y < count($pageComponents); $y++)
                        {
                        $module = $this->_Module->get($pageComponents[$y]['idModule']);

                            $data[$z]['children'][$y] = array
                            (
                            'id' => $pageComponents[$y]['idPageComponent'],
                            'idPageComponent' => $pageComponents[$y]['idPageComponent'],
                            'text' => $module['labelModule'].': '.$pageComponents[$y]['labelComponent'],
                            'icon' => 'engine/app/Modules/Page/admin/images/icon_PageComponent_small.png',
                            'leaf' => true,
                            'allowDrop' => false,
                            'nameModule' => $module['nameModule'],
                            'nameComponent' => $pageComponents[$y]['nameComponent'],
                            'nameBundle' => $pageComponents[$y]['nameBundle'] == $pageComponents[$y]['nameComponent'] ? null : $pageComponents[$y]['nameBundle'],
                            'labelComponent' => $pageComponents[$y]['labelComponent'],
                            'settings' => []
                            );

                            $pageComponentSettings = $this->_PageComponentSetting->read
                            (
                                [
                                    [
                                    'property' => 'idPageComponent',
                                    'value' => $pageComponents[$y]['idPageComponent']
                                    ]
                                ]
                            );

                            if($pageComponentSettings)
                            {
                                for($s = 0; $s < count($pageComponentSettings); $s++)
                                {
                                $data[$z]['children'][$y]['settings'][$pageComponentSettings[$s]['nameSetting']] = $pageComponentSettings[$s]['value'];
                                }
                            }
                        }
                    }
                }
            }
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
    $idPageComponent = $this->_PageComponent->create($Request->all());

        if($idPageComponent)
        {
            Log::info('Добавление компонента страницы.',
                [
                'module' => 'PageComponent',
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => true,
            'data' => $this->_PageComponent->get($idPageComponent)
            ];
        }
        else
        {
            Log::warning('Неудачное добавления компонента страницы.',
                [
                'module' => 'PageComponent',
                'login' => Auth::getUser()->login,
                'type' => 'create'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PageComponent->getErrorType(),
            'errormsg' => $this->_PageComponent->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Установка веса узла.
     * @param \App\Modules\PageComponent\Http\Requests\PageComponentAdminWeightRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function weight(PageComponentAdminWeightRequest $Request)
    {
        $status = $this->_PageComponentTreeArray->setPosition($Request->input('idPageComponent'), $Request->input('numberBlock'),
            [
                [
                'property' => 'idPage',
                'value' => $Request->input('idPage')
                ]
            ]
        );

        if($status)
        {
            $status = $this->_PageComponentTreeArray->setWeight($Request->input('idPageComponent'), $Request->input('weight'),
                [
                    [
                    'property' => 'idPage',
                    'value' => $Request->input('idPage')
                    ]
                ]
            );

            if($status)
            {
                Log::info('Изменение порядка следования компонентов страницы.',
                    [
                    'module' => "PageComponent",
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
                Log::warning('Неудачное изменение порядка следования компонентов страницы.',
                    [
                    'module' => "PageComponent",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_PageComponentTreeArray->getErrorType(),
                'errormsg' => $this->_PageComponentTreeArray->getErrorMessage()
                ];
            }

        }
        else
        {
            Log::warning('Неудачное изменение порядка следования компонентов страницы.',
                [
                'module' => "PageComponent",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PageComponentTreeArray->getErrorType(),
            'errormsg' => $this->_PageComponentTreeArray->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Удаление данных.
     * @param \App\Modules\PageComponent\Http\Requests\PageComponentAdminDestroyRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function destroy(PageComponentAdminDestroyRequest $Request)
    {
    $record = $this->_PageComponent->get($Request->input('id'));

        if($record)
        {
            $status = $this->_PageComponentTreeArray->destroy($Request->input('id'), false,
                [
                    [
                    'property' => 'idPage',
                    'value' => $record['idPage']
                    ]
                ]
            );

            if($status == true && $this->_PageComponentTreeArray->hasError() == false)
            {
                Log::info('Удаление компонента страницы.',
                    [
                    'module' => "Page",
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
                Log::warning('Неудачное удаление компонента страницы.',
                    [
                    'module' => "Page",
                    'login' => Auth::getUser()->login,
                    'type' => 'destroy'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_PageComponentTreeArray->getErrorType(),
                'errormsg' => $this->_PageComponentTreeArray->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное удаление компонента страницы.',
                [
                'module' => "Page",
                'login' => Auth::getUser()->login,
                'type' => 'destroy'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_PageComponentTreeArray->getErrorType(),
            'errormsg' => $this->_PageComponentTreeArray->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
