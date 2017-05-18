<?php
/**
 * Логирование.
 * Пакет содержит классы драйверов для использование различных хранилищь для логирования.
 * @package App.Models.Logs
 * @since 1.0
 * @version 1.0
 */
namespace App\Models\Logs;

use Jackiedo\LogReader\LogReader;
use DB;
use Config;
use Illuminate\Database\Connection;


/**
 * Этот класс является реализацией считывания логов с базы данных MySQL.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogReaderDatabase extends LogReader
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
     * @since 1.0
     * @version 1.0
     */
    public function __construct($Сonnection, $table = "log")
    {
    parent::__construct();
    $this->_Сonnection = $Сonnection;
    $this->_table = $table;
    }


    /**
     * Разбор содержания логов в базе данных и запись их в массив.
     * @param string $content
     * @param string $allowedEnvironment
     * @param array $allowedLevel
     * @return array
     */
    protected function parseLog($content, $allowedEnvironment = null, $allowedLevel = [])
    {
        $records = $this->_Сonnection
        ->table($this->_table)
        ->get();

    $content = "";

        for($i = 0; $i < count($records); $i++)
        {
            if($content) $content .= "\n";

        $pattern = $this->patternable->getHeaderPattern();
        preg_match_all($pattern, $records[$i]['formatted'], $headings);

            if (is_array($headings))
            {
            list($headerList, $dateList, $envList, $levelList) = $headings;
            $content .= '['.$dateList[0].'] '.$envList[0].'.'.$levelList[0].': '.$records[$i]['message'].' ~|~ '.$records[$i]['context'];
            }
        }

    $results = parent::parseLog($content, $allowedEnvironment, $allowedLevel);

        for($i = 0; $i < count($results); $i++)
        {
        $header = explode(' ~|~ ', $results[$i]['header']);
        $results[$i]['header'] = $header[0];

            if(isset($header[1])) $results[$i]['context'] = json_decode($header[1], true);
            else $results[$i]['context'] = [];
        }

    return $results;
    }
}