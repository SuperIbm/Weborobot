<?php
/**
 * Логирование.
 * Пакет содержит классы драйверов для использование различных хранилищь для логирования.
 * @package App.Models.Logs
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Logs;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Database\Connection;


/**
 * Этот класс является реализацией записи для системы Monolog в базу данных MySQL.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogWriterDatabase extends AbstractProcessingHandler
{
/**
 * Объект базы данных.
 * @var \DB
 * @version 1.0
 * @since 1.0
 */
protected $_Сonnection;

/**
 * Имя таблицы базы данных для хранения логов.
 * @var string
 * @version 1.0
 * @since 1.0
 */
private $_table = 'log';

	/**
	 * Конструктор.
	 * @param \Illuminate\Database\Connection $Сonnection Соедниение с базой данных.
	 * @param string $table Название таблицы для сохранения лога.
	 * @param int $level Уровень логирования.
	 * @param bool $bubble Метод сохранения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function __construct(Connection $Сonnection, $table = "log", $level = Logger::DEBUG, $bubble = true)
    {
    parent::__construct($level, $bubble);
    $this->_Сonnection = $Сonnection;
    $this->_table = $table;
    }


	/**
	 * Запись лога.
	 * @param array $record Данные для записи.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
    protected function write(array $record)
    {
    $Date = new \DateTime($record['datetime']->format('Y-m-d H:i:s'));

        /**
         * @var $record \App\Models\CarbonLocalized[]
         */
        $data = array
        (
        'channel' => $record['channel'],
        'message' => $record['message'],
        'level' => $record['level'],
        'level_name' => $record['level_name'],
        'context' => json_encode($record['context']),
        'formatted' => $record['formatted'],
        'dateAdd' => $Date->format('Y-m-d H:i:s')
        );

    $queryCellStr = "";
    $queryValueStr = "";

        foreach($data as $key => $value)
        {
            if($queryCellStr != "") $queryCellStr .= ", ";
            if($queryValueStr != "") $queryValueStr .= ", ";

        $queryCellStr .= $key;
        $queryValueStr .= "'".addslashes(trim($value))."'";
        }

        $this->_Сonnection
        ->getPdo()
        ->query("INSERT INTO ".$this->_table." (".$queryCellStr.") VALUES (".$queryValueStr .")");
    }
}