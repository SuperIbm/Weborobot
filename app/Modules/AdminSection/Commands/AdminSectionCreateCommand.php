<?php
/**
 * Модуль Разделы административной системы.
 * Этот модуль содержит все классы для работы с разделами административной системы.
 * @package App.Modules.AdminSection
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\AdminSection\Commands;

use Util;
use Illuminate\Console\Command;
use App\Modules\Module\Repositories\Module;
use App\Modules\AdminSection\Repositories\AdminSectionTreeArray;
use App\Modules\User\Repositories\UserRoleAdminSection;


/**
 * Класс комманда для создания раздела административной системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AdminSectionCreateCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:adminSection-create {name : A name of the module.} {label : A label of the admin section} {bundle : A bundle of the admin section}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Create a new admin section in the system.';

/**
 * Репозитарий разделов административной системы в виде древовидной струтктуры.
 * @var \App\Modules\AdminSection\Repositories\AdminSectionTreeArray
 * @version 1.0
 * @since 1.0
 */
private $_AdminSectionTreeArray;

/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

/**
 * Репозитарий для выбранных разделов роли.
 * @var \App\Modules\User\Repositories\UserRoleAdminSection
 * @version 1.0
 * @since 1.0
 */
private $_UserRoleAdminSection;

    /**
     * Конструктор.
     * @param \App\Modules\AdminSection\Repositories\AdminSectionTreeArray $AdminSectionTreeArray Репозитарий разделов административной системы в виде древовидной струтктуры.
     * @param \App\Modules\User\Repositories\UserRoleAdminSection $UserRoleAdminSection Репозитарий для выбранных разделов роли.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(AdminSectionTreeArray $AdminSectionTreeArray, UserRoleAdminSection $UserRoleAdminSection, Module $Module)
    {
    parent::__construct();
    $this->_AdminSectionTreeArray = $AdminSectionTreeArray;
    $this->_UserRoleAdminSection = $UserRoleAdminSection;
    $this->_Module = $Module;
    }

    /**
	 * Выполнение комманды.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function fire()
	{
    $this->line('Creating the admin section...');

        $module = $this->_Module->read
        (
            [
                [
                'property' => 'nameModule',
                'value' => $this->argument("name")
                ]
            ]
        );

        if($module)
        {
        $encoding = mb_detect_encoding($this->argument("label"), null, true);

            if($encoding != "UTF-8") $label = Util::iconv($this->argument("label"), 'windows-1251', 'utf-8');
            else $label = $this->argument("label");

            $idAdminSection = $this->_AdminSectionTreeArray->create
            (
                [
                'idModule' => $module[0]['idModule'],
                'labelSection' => $label,
                'bundle' => $this->argument("bundle"),
                'iconSmall' => $this->ask('Input a path to an icon small', 'app/Modules/'.$module[0]['nameModule'].'/Admin/images/icon_small.png'),
                'iconBig' => $this->ask('Input a path to an icon big', 'app/Modules/'.$module[0]['nameModule'].'/Admin/images/icon_big.png'),
                'pathToJs' => $this->ask('Input a path to an index JavaScript file', 'app/Modules/'.$module[0]['nameModule'].'/Admin/js/index.js'),
                'pathToCss' => $this->ask('Input a path to a CSS file', 'app/Modules/'.$module[0]['nameModule'].'/Admin/css/main.css'),
                'menuLeft' => $this->confirm('Do you want to place the icon in the left menu in the admin panel? [Y|N]'),
                'status' => true
                ]
            );

            if($idAdminSection)
            {
                $this->_UserRoleAdminSection->create
                (
                    [
                    'idUserRole' => 1,
                    'idAdminSection' => $idAdminSection,
                    'isRead' => 1,
                    'isUpdate' => 1,
                    'isCreate' => 1,
                    'isDestroy' => 1
                    ]
                );

                $this->_UserRoleAdminSection->create
                (
                    [
                    'idUserRole' => 2,
                    'idAdminSection' => $idAdminSection,
                    'isRead' => 1,
                    'isUpdate' => 1,
                    'isCreate' => 1,
                    'isDestroy' => 0
                    ]
                );

            $this->info('Finished creation of the admin section.');
            }
            else $this->error($this->_AdminSectionTreeArray->getErrorType().": ".$this->_AdminSectionTreeArray->getErrorMessage());
        }
        else $this->error("The module is not exists.");
	}
}
