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
 * Этот класс является реализацией считывания логов с файла.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogReaderFile extends LogReader
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
    private function parseLog($content, $allowedEnvironment = null, $allowedLevel = [])
    {
    $results = parent::parseLog($content, $allowedEnvironment, $allowedLevel);

        for($i = 0; $i < count($results); $i++)
        {
        preg_match("/{.+}/", $results[$i]['header'], $json);

            if($json) $results[$i]['context'] = json_decode($json[0], true);
            else $results[$i]['context'] = [];
        }

    return $results;
    }
}