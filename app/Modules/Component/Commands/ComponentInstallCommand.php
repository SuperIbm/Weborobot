<?php
/**
 * Модуль Компонента.
 * Этот модуль содержит все классы для работы с компонентами системы.
 * @package App.Modules.Component
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Component\Commands;

use Illuminate\Console\Command;
use App\Modules\Component\Repositories\Component;


/**
 * Класс комманда для установки компонента.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ComponentInstallCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:component-install {nameDir : A dir of the module.} {file : A zip file of the module}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Install a new component in the system.';

/**
 * Репозитарий компонентов.
 * @var \App\Modules\Component\Repositories\Component
 * @version 1.0
 * @since 1.0
 */
private $_Component;

    /**
     * Конструктор.
     * @param \App\Modules\Component\Repositories\Component $Component Репозитарий компонентов.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Component $Component)
    {
    parent::__construct();
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
    $this->line('Installing the component...');
    $this->_Component->install($this->argument("nameDir"), $this->argument("file"));
    $this->info('Finished installation of the component.');
	}
}
