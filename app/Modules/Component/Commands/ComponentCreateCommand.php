<?php
/**
 * Модуль Компонента.
 * Этот модуль содержит все классы для работы с компонентами системы.
 * @package App.Modules.Component
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Component\Commands;

use Util;
use Illuminate\Console\Command;
use App\Modules\Module\Repositories\Module;
use App\Modules\Component\Repositories\Component;


/**
 * Класс комманда для создания компонента.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ComponentCreateCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:component-create {name : A name of the module.} {controller : A name of controller\'s class} {nameComponent : A name of the component} {label : A label of the component}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Create a new component in the system.';

/**
 * Репозитарий компонентов.
 * @var \App\Modules\Component\Repositories\Component
 * @version 1.0
 * @since 1.0
 */
private $_Component;

/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

    /**
     * Конструктор.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @param \App\Modules\Component\Repositories\Component $Component Репозитарий компонентов.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Component $Component, Module $Module)
    {
    parent::__construct();
    $this->_Module = $Module;
    $this->_Component = $Component;
    }

    /**
	 * Выполнение комманды.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function fire()
	{
    $this->line('Creating the component...');

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

        $pathToJs = $this->ask('Input a path to an index JavaScript file', 'app/Modules/'.$module[0]['nameModule'].'/Admin/js/component/'.$this->argument("nameComponent").'/js/index.js');
        $pathToCss = $this->ask('Input a path to a CSS file', 'NULL');

            if($pathToCss == "NULL") $pathToCss = null;

            $status = $this->_Component->create
            (
                [
                'idModule' => $module[0]['idModule'],
                'controller' => $this->argument("controller"),
                'nameComponent' => $this->argument("nameComponent"),
                'labelComponent' => $label,
                'pathToJs' => $pathToJs,
                'pathToCss' => $pathToCss,
                'status' => true
                ]
            );

            if($status) $this->info('Finished creation of the component.');
            else $this->error($this->_Component->getErrorType().": ".$this->_Component->getErrorMessage());
        }
        else $this->error("The module is not exists.");
	}
}
