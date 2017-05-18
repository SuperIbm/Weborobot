<?php
/**
 * Модуль Настройки компонента страницы.
 * Этот модуль содержит все классы для работы настройками компонента на странице.
 * @package App.Modules.PageComponentSetting
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponentSetting\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\PageComponentSetting\Repositories\PageComponentSetting;


/**
 * Класс контроллер для настроек компонентов страницы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageComponentSettingAdminController extends Controller
{
/**
 * Репозитарий страниц.
 * @var \App\Modules\PageComponentSetting\Repositories\PageComponentSetting
 * @version 1.0
 * @since 1.0
 */
private $_PageComponentSetting;

    /**
     * Конструктор.
     * @param \App\Modules\PageComponentSetting\Repositories\PageComponentSetting $PageComponentSetting Репозитарий страниц.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(PageComponentSetting $PageComponentSetting)
    {
    $this->_PageComponentSetting = $PageComponentSetting;
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
        if($Request->input('idPageComponent'))
        {
            $records = $this->_PageComponentSetting->read
            (
                [
                    [
                    'property' => 'idPageComponent',
                    'value' => $Request->input('idPageComponent')
                    ]
                ]
            );

            if($records)
            {
                for($i = 0; $i < count($records); $i++)
                {
                $this->_PageComponentSetting->destroy($records[$i]['idPageComponentSetting']);
                }
            }

        $data = $Request->all();

            foreach($data AS $k => $v)
            {
                if($k == "idPageComponent") continue;

                $this->_PageComponentSetting->create
                (
                    [
                    'idPageComponent' => $Request->input('idPageComponent'),
                    'nameSetting' => $k,
                    'value' => $v
                    ]
                );
            }

            Log::info('Обновление настроек компонента страницы.',
                [
                'module' => "Page",
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
            Log::warning('Неудачное обновление настроек компонента страницы.',
                [
                'module' => "Page",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false
            ];
        }

    return response()->json($data);
    }
}
