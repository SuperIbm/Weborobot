<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Http\Controllers;

use Log;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\Module\Repositories\Module;

use App\Modules\Module\Http\Requests\ModuleAdminReadRequest;
use App\Modules\Module\Http\Requests\ModuleAdminCreateRequest;
use App\Modules\Component\Repositories\Component;

/**
 * Класс контроллер для работы с Модулями в административной системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleAndComponentAdminController extends Controller
{
/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

/**
 * Репозитарий компонентов.
 * @var \App\Modules\Component\Repositories\Component
 * @version 1.0
 * @since 1.0
 */
private $_Component;

    /**
     * Конструктор.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @param \App\Modules\Component\Repositories\Component $Component Репозитарий компонентов.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Module $Module, Component $Component)
    {
    $this->_Module = $Module;
    $this->_Component = $Component;
    }


    /**
     * Древовидная струткра модулей.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function tree()
    {
        $data = $this->_Module->read
        (
        null,
        null,
            [
                [
                'property' => 'labelModule',
                'direction' => 'ASC'
                ]
            ]
        );

        if($this->_Module->hasError() == false && $data)
        {
        $dataWithComonents = [];

            for($i = 0, $y = 0; $i < count($data); $i++)
            {
                $components = $this->_Component->read
                (
                    [
                        [
                        'property' => 'idModule',
                        'value' => $data[$i]['idModule']
                        ]
                    ],
                    true
                );

                if($components)
                {
                $dataWithComonents[$y]['text'] = $data[$i]['labelModule'];
                $dataWithComonents[$y]['leaf'] = false;
                $dataWithComonents[$y]['children'] = [];
                $dataWithComonents[$y]['icon'] = 'engine/app/Modules/Module/Admin/images/icon_small.png';

                $dataWithComonents[$y]['children'] = [];

                    for($z = 0; $z < count($components); $z++)
                    {
                    $dataWithComonents[$y]['children'] =
                        [
                        'text' => $components[$z]["labelComponent"],
                        'leaf' => true,
                        'allowDrag' => true,
                        'allowDrop' => false,
                        'icon' => 'engine/app/Modules/Page/admin/images/icon_Component_small.png',
                        'nameModule' => $data[$i]['nameModule'],
                        'nameComponent' => $components[$z]['nameComponent'],
                        'labelComponent' => $components[$z]['labelComponent'],
                        'nameBundle' => $components[$z]['nameBundle'] == $components[$z]['nameComponent'] ? null : $components[$z]['nameBundle'],
                        'idComponent' => $components[$z]['idComponent'],
                        ];
                    }

                $y++;
                }
            }

        $data = $dataWithComonents;
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
