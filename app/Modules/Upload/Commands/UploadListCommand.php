<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Commands;

use Config;
use Util;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Modules\Upload\Repositories\Upload;


/**
 * Класс комманда для вывода списка доступных обновлений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadListCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:upload-list {start=0 : Start point} {limit=20 : Limit for list}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Show a list of available updating for the system.';

/**
 * Репозитарий обновления.
 * @var \App\Modules\Upload\Repositories\Upload
 * @version 1.0
 * @since 1.0
 */
private $_Upload;

    /**
     * Конструктор.
     * @param \App\Modules\Upload\Repositories\Upload $Upload Репозитарий для обновления.
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Upload $Upload)
    {
    parent::__construct();
    $this->_Upload = $Upload;
    }

    /**
	 * Выполнение комманды.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function fire()
	{
        $result = $this->_Upload->read
        (
        null,
            [
                [
                'property' => 'nameModule',
                'direction' => 'ASC'
                ]
            ],
        $this->argument("start"),
        $this->argument('limit'),
            [
            "Module"
            ]
        );

        if($result)
        {
            $headers =
            [
            'ID',
            'Name module',
            'Current version',
            'Current date',
            'Next version',
            'Next date'
            ];

        $data = [];

            for($i = 0; $i < count($result); $i++)
            {
                $data[] =
                [
                $result[$i]['idUpload'],
                $result[$i]['module']['nameModule'],
                Config::get(Util::toLower($result[$i]["module"]['nameModule']).'.version'),
                Carbon::createFromFormat('Y-m-d', Config::get(Util::toLower($result[$i]["module"]['nameModule']).'.date'))->format('d.m.Y'),
                $result[$i]['nextVersion'],
                Carbon::createFromFormat('Y-m-d H:i:s', $result[$i]['nextDate'])->format('d.m.Y')
                ];
            }

        $from = $this->argument("start") + 1;
        $this->line('Showing records from '.$from.' to '.count($result).', total is '.$this->_Upload->count().'.');
        $this->table($headers, $data);
        }
        else $this->info('The list is empty.');
	}
}
