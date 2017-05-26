<?php
/**
 * Модуль Виджеты.
 * Этот модуль содержит все классы для работы с виджетами.
 * @package App.Modules.Widget
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Widget\Commands;

use Util;
use Illuminate\Console\Command;
use App\Modules\Module\Repositories\Module;
use App\Modules\Widget\Repositories\Widget;


/**
 * Класс комманда для создания виджета.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class WidgetCreateCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:widget-create {name : A name of the module.} {nameWidget : A name of the widget} {label : A label of the widget}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Create a new widget in the system.';

/**
 * Репозитарий виджетов.
 * @var \App\Modules\Widget\Repositories\Widget
 * @version 1.0
 * @since 1.0
 */
private $_Widget;

/**
 * Репозитарий модулей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

    /**
     * Конструктор.
     * @param \App\Modules\Widget\Repositories\Widget $Widget Репозитарий виджетов.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Widget $Widget, Module $Module)
    {
    parent::__construct();
    $this->_Module = $Module;
    $this->_Widget = $Widget;
    }

    /**
	 * Выполнение комманды.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function fire()
	{
    $this->line('Creating the widget...');

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

        $pathToJs = $this->ask('Input a path to an index JavaScript file', 'app/Modules/'.$module[0]['nameModule'].'/Admin/js/widget/'.$this->argument("nameWidget").'/js/index.js');
        $pathToCss = $this->ask('Input a path to a CSS file', 'NULL');

            if($pathToCss == "NULL") $pathToCss = null;

            $status = $this->_Widget->create
            (
                [
                'idModule' => $module[0]['idModule'],
                'actionWidget' => $this->argument("nameWidget"),
                'labelWidget' => $label,
                'icon' => $this->ask('Input a path to an icon', 'app/Modules/'.$module[0]['nameModule'].'/Admin/images/icon_small.png'),
                'pathToCss' => $pathToCss,
                'pathToJs' => $pathToJs,
                'def' => $this->confirm('Show the widget by default? [Y|N]'),
                'status' => true
                ]
            );

            if($status) $this->info('Finished creation of the widget.');
            else $this->error($this->_Widget->getErrorType().": ".$this->_Widget->getErrorMessage());
        }
        else $this->error("The module is not exists.");
	}
}
