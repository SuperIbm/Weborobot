<?php
/**
 * Модуль Блоки страницы.
 * Этот модуль содержит все классы для работы с блокми страницы.
 * @package App.Modules.Block
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Block\Models;

use Route;
use Util;
use App\Modules\Page\Repositories\Page;
use App\Modules\PageTemplate\Repositories\PageTemplate;
use App\Modules\PageComponent\Repositories\PageComponent;
use App\Modules\PageComponentSetting\Repositories\PageComponentSetting;
use App\Modules\Module\Repositories\Module;

/**
 * Класс для получения блоков у страницы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Block
{
/**
 * Репозитарий страниц.
 * @var \App\Modules\Page\Repositories\Page
 * @version 1.0
 * @since 1.0
 */
private $_Page;

/**
 * Репозитарий компонентов страницы.
 * @var \App\Modules\PageComponent\Repositories\PageComponent
 * @version 1.0
 * @since 1.0
 */
private $_PageComponent;

/**
 * Репозитарий настроек компонентов страницы.
 * @var \App\Modules\PageComponentSetting\Repositories\PageComponentSetting
 * @version 1.0
 * @since 1.0
 */
private $_PageComponentSetting;

/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

/**
 * HTTP статус измененный в результате работы компонентов в блоке.
 * @var int
 * @version 1.0
 * @since 1.0
 */
private $_status = 200;

    /**
     * Установка HTTP статуса.
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
     * Получение HTTP статуса.
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
     * Конструктор.
     * @param \App\Modules\Page\Repositories\Page $Page Репозитарий страниц.
     * @param \App\Modules\PageTemplate\Repositories\PageTemplate $PageTemplate Репозитарий шаблонов страницы.
     * @param \App\Modules\PageComponent\Repositories\PageComponent $PageComponent Репозитарий компонентов.
     * @param \App\Modules\PageComponentSetting\Repositories\PageComponentSetting $PageComponentSetting Репозитарий настроек компонентов.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Page $Page, PageTemplate $PageTemplate, PageComponent $PageComponent, PageComponentSetting $PageComponentSetting, Module $Module)
    {
    $this->_Page = $Page;
    $this->_PageTemplate = $PageTemplate;
    $this->_PageComponent = $PageComponent;
    $this->_PageComponentSetting = $PageComponentSetting;
    $this->_Module = $Module;
    }

    /**
     * Рендеринг и получение HTML блока.
     * @param string $path Путь к странице, которую нужно отрендерить.
     * @param int $number Номер блока для получения. Если не указать, верент массив всех блоков.
     * @param array $params Параметры полученные с ссылки.
     * @return string|array|bool HTML блоки страницы.
     * @since 1.0
     * @version 1.0
     */
    public function render($path, $number = null, $params = [])
    {
    $url = parse_url($path);

        if(isset($url['path']))
        {
            if(substr($url['path'], 0, 1) == '/') $url['path'] = substr($url['path'], 1, strlen($url['path']));
            if(substr($url['path'], Util::strlen($url['path']) - 1, Util::strlen($url['path'])) != '/') $url['path'] .= '/';

        $page = $this->_Page->getByDirname($url['path'], true, true);
        }
        else $page = $this->_Page->getByDirname('', true, true);

        if($page)
        {
        $blocks = [];
        $pageTemplate = $this->_PageTemplate->get($page['idPageTemplate'], true);

            if($pageTemplate['countBlocks'])
            {
                for($i = 1; $i < $pageTemplate['countBlocks']; $i++)
                {
                    if($number && $number != $i) continue;

                    $pageComponents = $this->_PageComponent->read
                    (
                        [
                            [
                            'property' => 'idPage',
                            'value' => $page['idPage']
                            ],
                            [
                            'property' => 'numberBlock',
                            'value' => $i
                            ]
                        ],
                        [
                            [
                            'property' => 'weight',
                            'direction' => 'ASC'
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
                        for($z = 0; $z < count($pageComponents); $z++)
                        {
                        $pageComponents[$z]['component']['module'] = $this->_Module->get($pageComponents[$z]['component']['idModule']);

                            $settings = $this->_PageComponentSetting->read
                            (
                                [
                                    [
                                    'property' => 'idPageComponent',
                                    'value' => $pageComponents[$z]['idPageComponent']
                                    ]
                                ]
                            );

                        $Controller = app('App\Modules\\'.$pageComponents[$z]['component']['module']['nameModule'].'\Http\Controllers\\'.$pageComponents[$z]['component']['controller']);
                        $Request = request();
                        $Request->request->add(['numberBlock' => $i]);

                            if($settings)
                            {
                                for($y = 0; $y < count($settings); $y++)
                                {
                                $Request->request->add([$settings[$y]['nameSetting'] => $settings[$y]['value']]);
                                }
                            }

                        $parameters = [$Request];
                        $parameters = array_merge($parameters, $params);

                        /**
                         * @var \Symfony\Component\HttpFoundation\Response $Response
                         */
                        $Response = $Controller->callAction($pageComponents[$z]['component']['nameComponent'], $parameters);

                            if($Response)
                            {
                            $Response = Route::prepareResponse($Request, $Response);
                            $Response->sendHeaders();
                            $this->_setStatus($Response->getStatusCode());

                            $blocks[$i] = $Response->getContent();
                            }
                        }
                    }
                }
            }

            if($number && $blocks[$number]) return $blocks[$number];
            else if(!$number && $blocks) return $blocks;
            else return false;
        }
        else return false;
    }
}