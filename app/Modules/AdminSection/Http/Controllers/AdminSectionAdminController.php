<?php
/**
 * Модуль Разделы административной системы.
 * Этот модуль содержит все классы для работы с разделами административной системы.
 * @package App.Modules.AdminSection
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\AdminSection\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Log;
use Auth;

use App\Modules\AdminSection\Repositories\AdminSection;
use App\Modules\AdminSection\Repositories\AdminSectionTreeArray;

use App\Modules\User\Repositories\UserRoleAdminSection;

use App\Modules\AdminSection\Http\Requests\AdminSectionAdminReadRequest;
use App\Modules\AdminSection\Http\Requests\AdminSectionAdminWeightRequest;

/**
 * Класс контроллер для разделов административной системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AdminSectionAdminController extends Controller
{
/**
 * Репозитарий разделов административной системы.
 * @var \App\Modules\AdminSection\Repositories\AdminSection
 * @version 1.0
 * @since 1.0
 */
private $_AdminSection;

/**
 * Репозитарий разделов административной системы в виде древовидной струтктуры.
 * @var \App\Modules\AdminSection\Repositories\AdminSectionTreeArray
 * @version 1.0
 * @since 1.0
 */
private $_AdminSectionTreeArray;

/**
 * Репозитарий выбранных разделов роли.
 * @var \App\Modules\User\Repositories\UserRoleAdminSection
 * @version 1.0
 * @since 1.0
 */
private $_UserRoleAdminSection;

    /**
     * Конструктор.
     * @param \App\Modules\AdminSection\Repositories\AdminSection $AdminSection Репозитарий разделов административной системы.
     * @param \App\Modules\AdminSection\Repositories\AdminSectionTreeArray $AdminSectionTreeArray Репозитарий разделов административной системы в виде древовидной струтктуры.
     * @param \App\Modules\User\Repositories\UserRoleAdminSection $UserRoleAdminSection Репозитарий выбранных разделов роли.
     * @since 1.0
     * @version 1.0
     */
    public function __construct(AdminSection $AdminSection, AdminSectionTreeArray $AdminSectionTreeArray, UserRoleAdminSection $UserRoleAdminSection)
    {
    $this->_AdminSection = $AdminSection;
    $this->_AdminSectionTreeArray = $AdminSectionTreeArray;
    $this->_UserRoleAdminSection = $UserRoleAdminSection;
    }

    /**
     * Чтение данных.
     * @param \App\Modules\AdminSection\Http\Requests\AdminSectionAdminReadRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function read(AdminSectionAdminReadRequest $Request)
    {
    $filters = [];

        if($Request->input('id'))
        {
            $filters[] =
            [
            'property' => 'idAdminSection',
            'value' => $Request->input('id')
            ];

        $data = $this->_AdminSection->read($filters);
        }
        else
        {
            if($Request->input('bundleShow'))
            {
                $filters[] =
                [
                'property' => 'bundle',
                'value' => $Request->input('bundleShow')
                ];
            }

            $data = $this->_AdminSection->read
            (
                $filters,
                null,
                [
                    [
                    'property' => "bundle",
                    'direction' => "ASC"
                    ],
                    [
                    'property' => "weight",
                    'direction' => "ASC"
                    ]
                ],
                null,
                null,
                [
                'Module'
                ]
            );

            if($Request->input('idUserRole') && $data)
            {
                for($i = 0; $i < count($data); $i++)
                {
                    $userRoleAdminSection = $this->_UserRoleAdminSection->read
                    (
                        [
                            [
                            'property' => 'idUserRole',
                            'value' => $Request->input('idUserRole')
                            ],
                            [
                            'property' => "idAdminSection",
                            'value' => $data[$i]['idAdminSection']
                            ]
                        ]
                    );

                    if($userRoleAdminSection)
                    {
                    $data[$i]['isCreate'] = $userRoleAdminSection[0]['isCreate'];
                    $data[$i]['isDestroy'] = $userRoleAdminSection[0]['isDestroy'];
                    $data[$i]['isRead'] = $userRoleAdminSection[0]['isRead'];
                    $data[$i]['isUpdate'] = $userRoleAdminSection[0]['isUpdate'];
                    }
                    else
                    {
                    $data[$i]['isCreate'] = "Нет";
                    $data[$i]['isDestroy'] = "Нет";
                    $data[$i]['isRead'] = "Нет";
                    $data[$i]['isUpdate'] = "Нет";
                    }
                }
            }
        }

        if($this->_AdminSection->hasError() == false)
        {
            $data =
            [
            "data" => $data == null ? [] : $data,
            "total" => $this->_AdminSection->count($filters),
            "success" => true
            ];
        }
        else
        {
            $data =
            [
            "success" => false
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
        if($Request->input('idAdminSection'))
        {
        $data = $Request->all();

        unset($data['labelSection']);
        unset($data['idModule']);
        unset($data['bundle']);
        unset($data['weight']);
        unset($data['isRead']);
        unset($data['isUpdate']);
        unset($data['isCreate']);
        unset($data['isDestroy']);

        $status = $this->_AdminSection->update($Request->input('idAdminSection'), $data);

            if($status)
            {
                Log::info('Обновление раздела административной системы.',
                    [
                    'module' => "AdminSection",
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
                Log::warning('Неудачное обновление раздела административной системы.',
                    [
                    'module' => "AdminSection",
                    'login' => Auth::getUser()->login,
                    'type' => 'update'
                    ]
                );

                $data =
                [
                'success' => false,
                'errortype' => $this->_AdminSection->getErrorType(),
                'errormsg' => $this->_AdminSection->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Неудачное обновление раздела административной системы.',
                [
                'module' => "AdminSection",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_AdminSection->getErrorType(),
            'errormsg' => $this->_AdminSection->getErrorMessage()
            ];
        }

    return response()->json($data);
    }


    /**
     * Установка веса узла.
     * @param \App\Modules\AdminSection\Http\Requests\AdminSectionAdminWeightRequest $Request Запрос.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     * @since 1.0
     * @version 1.0
     */
    public function weight(AdminSectionAdminWeightRequest $Request)
    {
    $status = $this->_AdminSectionTreeArray->setWeight($Request->input('id'), $Request->input('weight'));

        if($status)
        {
            Log::info('Изменение порядка следования раздела административной системы.',
                [
                'module' => "AdminSection",
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
            Log::warning('Неудачное изменение порядка следования раздела административной системы.',
                [
                'module' => "AdminSection",
                'login' => Auth::getUser()->login,
                'type' => 'update'
                ]
            );

            $data =
            [
            'success' => false,
            'errortype' => $this->_AdminSection->getErrorType(),
            'errormsg' => $this->_AdminSection->getErrorMessage()
            ];
        }

    return response()->json($data);
    }
}
