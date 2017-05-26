<?php
/**
 * Модуль Виджеты.
 * Этот модуль содержит все классы для работы с виджетами.
 * @package App.Modules.Widget
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Widget\Commands;

use Illuminate\Console\Command;
use \App\Modules\Widget\Repositories\Widget;


/**
 * Класс комманда для установки компонента.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class WidgetInstallCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:widget-install {nameDir : A dir of the module.} {file : A zip file of the module}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Install a new widget in the system.';

/**
 * Репозитарий виджета.
 * @var \App\Modules\Widget\Repositories\Widget
 * @version 1.0
 * @since 1.0
 */
private $_Widget;

    /**
     * Конструктор.
     * @param \App\Modules\Widget\Repositories\Widget $Widget Репозитарий виджета.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Widget $Widget)
    {
    parent::__construct();
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
    $this->line('Installing the widget...');
    $this->_Widget->install($this->argument("nameDir"), $this->argument("file"));
    $this->info('Finished installation of the widget.');
	}
}
