<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Commands;

use Illuminate\Console\Command;

use App\Modules\Upload\Repositories\Upload;
use App\Modules\Upload\Repositories\UploadSource;
use App\Modules\Module\Repositories\Module;


/**
 * Класс комманда для запуска обновления системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadSetCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:upload-set {module* : IDs of upload or name of module.}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Update a module in the system.';

/**
 * Репозитарий обновления.
 * @var \App\Modules\Upload\Repositories\Upload
 * @version 1.0
 * @since 1.0
 */
private $_Upload;

/**
 * Репозитарий обновления.
 * @var \App\Modules\Upload\Repositories\UploadSource
 * @version 1.0
 * @since 1.0
 */
private $_UploadSource;

/**
 * Репозитарий модудей.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
private $_Module;

    /**
     * Конструктор.
     * @param \App\Modules\Upload\Repositories\Upload $Upload Репозитарий для обновления.
     * @param \App\Modules\Upload\Repositories\UploadSource $UploadSource Репозитарий источник обновления.
     * @param \App\Modules\Module\Repositories\Module $Module Репозитарий модулей.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Upload $Upload, UploadSource $UploadSource, Module $Module)
    {
    parent::__construct();
    $this->_Upload = $Upload;
    $this->_UploadSource = $UploadSource;
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
    $this->line('Getting rules from remotes servers...');
    $rules = $this->_UploadSource->getRules();

        if($rules)
        {
        $this->info('Finished getting rules from the remotes servers.');
        $modules = $this->argument('module');

        $Bar = $this->output->createProgressBar(count($modules));

            for($i = 0; $i < count($modules); $i++)
            {
            $error = false;
            $idUpload = null;
            $nameModule = null;

                if(is_string($modules[$i]))
                {
                $nameModule = $modules[$i];

                    $module = $this->_Module->read
                    (
                        [
                            [
                            'property' => 'nameModule',
                            'value' => $nameModule
                            ]
                        ],
                        null,
                        null,
                        null,
                        null,
                        [
                        'Upload'
                        ]
                    );

                    if(isset($module[0]['upload']['idUpload'])) $idUpload = $module[0]['upload']['idUpload'];
                    else $error = 'The updating for module '.$modules[$i].' is not exist.';
                }
                else
                {
                $idUpload = $modules[$i];

                    $upload = $this->_Upload->read
                    (
                        [
                            [
                            'property' => 'idUpload',
                            'value' => $idUpload
                            ]
                        ],
                        null,
                        null,
                        null,
                        [
                        'Module'
                        ]
                    );

                    if($upload) $nameModule = $upload['module']['nameModule'];
                    else $error = 'The updating for module '.$modules[$i].' is not exist.';
                }

                if($error == false && $idUpload && $nameModule)
                {
                $this->line('Updating the '.$nameModule.'...');
                $status = $this->_Upload->set($idUpload, $rules);

                $Bar->advance();
                $this->line("");

                    if($status) $this->info('New version of '.$nameModule.' has been successfully installed.');
                    else $this->error('During execution of installation '.$nameModule.' the error occurred.');
                }
                else
                {
                $Bar->advance();
                $this->line("");
                $this->error($error);
                }
            }

        $Bar->finish();
        $this->line("");
        $this->info('Finished installation of updating.');
        }
        else $this->error('We cannot get new rules for updating.');
	}
}
