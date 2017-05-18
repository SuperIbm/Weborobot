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


/**
 * Класс комманда для проверки обновления системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadCheckCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:upload-check';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Check a new updating for the system.';

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
     * Конструктор.
     * @param \App\Modules\Upload\Repositories\Upload $Upload Репозитарий для обновления.
     * @param \App\Modules\Upload\Repositories\UploadSource $UploadSource Репозитарий источник обновления.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Upload $Upload, UploadSource $UploadSource)
    {
    parent::__construct();
    $this->_Upload = $Upload;
    $this->_UploadSource = $UploadSource;
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

        $this->line('Checking available new versions...');
        $status = $this->_Upload->check($rules);

            if($status) $this->info('New versions have been successfully matched.');
            else $this->error('During execution the error occurred.');
        }
        else $this->error('We cannot get new rules for updating.');
	}
}
