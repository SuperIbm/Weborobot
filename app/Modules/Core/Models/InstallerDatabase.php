<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use DB;
use Config;
use App\Models\Decorator;
use PDOException;

/**
 * Запуск установки конфигурации базы данных.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerDatabase extends Decorator
{
    /**
     * Метод получения индекса.
     * Этот индекс используется в массиве данных для сохранения тех данных, которые были созданы этим декоратором.
     * @return string Название индекса.
     * @since 1.0
     * @version 1.0
     */
    public function getIndex()
    {
    return "database";
    }


    /**
     * Запуск установщика.
     * @param array $params Параметры декоратора.
     * @param \App\Models\Decorator $ParentDecorator Родительский декоратор.
     * @return bool Должен вернуть true если действие выполнено успешно.
     * @since 1.0
     * @version 1.0
     */
    protected function _action($params, Decorator $ParentDecorator = null)
    {
    $connected = false;

        $data = 
        [
        'DB_CONNECTION' => 'mysql',
        'DB_MYSQL_HOST' => '',
        'DB_MYSQL_PORT' => 3306,
        'DB_MYSQL_DATABASE' => '',
        'DB_MYSQL_USERNAME' => '',
        'DB_MYSQL_PASSWORD' => ''
        ];

    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();

        while (!$connected)
        {
        $data['DB_MYSQL_HOST'] = $Root->getCommand()->ask('Enter your database host', 'localhost');
        $data['DB_MYSQL_DATABASE'] = $Root->getCommand()->ask('Enter your database name', 'weborobot');
        $data['DB_MYSQL_USERNAME'] = $Root->getCommand()->ask('Enter your database username', 'root');
        $data['DB_MYSQL_PASSWORD'] = $Root->getCommand()->ask('Enter your database password', 'NULL');

            if($data['DB_MYSQL_PASSWORD'] == "NULL") $data['DB_MYSQL_PASSWORD'] = null;

        Config::set('database.connections.mysql.host', $data['DB_MYSQL_HOST']);
        Config::set('database.connections.mysql.database', $data['DB_MYSQL_DATABASE']);
        Config::set('database.connections.mysql.username', $data['DB_MYSQL_USERNAME']);
        Config::set('database.connections.mysql.password', $data['DB_MYSQL_PASSWORD']);

            try
            {
            DB::reconnect();
            $connected = true;
            }
            catch(PDOException $e)
            {
            $Root->getCommand()->error("Please ensure your database credentials are valid.");
            }
        }

    $this->_setData($data);
    return true;
    }
}
