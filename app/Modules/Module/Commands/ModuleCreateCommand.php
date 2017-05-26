<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Commands;

use Util;
use Illuminate\Console\Command;
use App\Modules\Module\Repositories\Module;


/**
 * Класс комманда для создания модуля.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleCreateCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:module-create {name : A name of the module.} {label : A label of the module}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Create a new module in the system.';

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
    $this->line('Creating the module...');
    $encoding = mb_detect_encoding($this->argument("label"), null, true);

        if($encoding != "UTF-8") $label = Util::iconv($this->argument("label"), 'windows-1251', 'utf-8');
        else $label = $this->argument("label");

        $idModule = $this->_Module->create
        (
            [
            "nameModule" => $this->argument("name"),
            "labelModule" => $label,
            "status" => true
            ]
        );

        if($idModule)
        {
            if($this->confirm('Do you want to create dirs and files for the module? [y|N]'))
            {
                $this->call('module:make',
                    [
                    'module-name' => $this->argument("name")
                    ]
                );
            }

            if($this->confirm('Do you want to create admin section for the module? [Y|N]'))
            {
            $bundle = $this->choice('What is a bundle of admin section?', ['CONTENT', 'SERVICES', 'MANEGER', 'SYSTEM', 'SEO'], 'CONTENT');

                $this->call('weborobot:adminSection-create',
                    [
                    'name' => $this->argument("name"),
                    'label' => $label,
                    'bundle' => $bundle
                    ]
                );
            }

        $this->info('Finished creation of the module.');
        }
        else $this->error($this->_Module->getErrorType().": ".$this->_Module->getErrorMessage());
	}
}
