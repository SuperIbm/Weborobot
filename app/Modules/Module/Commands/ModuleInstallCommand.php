<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Commands;

use Illuminate\Console\Command;
use App\Modules\Module\Repositories\Module;


/**
 * Класс комманда для установки модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleInstallCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:module-install {nameDir : A dir of the module.} {file : A zip file of the module}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Install a new module in the system.';

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
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Module $Module)
    {
    parent::__construct();
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
    $this->line('Installing the module...');
    $this->_Module->install($this->argument("nameDir"), $this->argument("file"));
    $this->info('Finished installation of the module.');
	}
}
