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
 * Запуск установки конфигурации базы данных MongoDb.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerMongoDb extends Decorator
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
    return "mongoDb";
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
        'DB_MONGODB_HOST' => '',
        'DB_MONGODB_PORT' => '',
        'DB_MONGODB_DATABASE' => '',
        'DB_MONGODB_USERNAME' => '',
        'DB_MONGODB_PASSWORD' => ''
        ];

    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();

        if($Root->getCommand()->confirm('Would you like setting MongoDB for your system? [Y|N]', false))
        {
            while (!$connected)
            {
            /**
             * @var $Root \App\Modules\Core\Models\Installer
             */
            $data['DB_MONGODB_HOST'] = $Root->getCommand()->ask('Enter your database host', 'localhost');
            $data['DB_MONGODB_PORT'] = $Root->getCommand()->ask('Enter your port', '27017');
            $data['DB_MONGODB_DATABASE'] = $Root->getCommand()->ask('Enter your database name', 'weborobot');
            $data['DB_MONGODB_USERNAME'] = $Root->getCommand()->ask('Enter your database username', 'root');
            $data['DB_MONGODB_PASSWORD'] = $Root->getCommand()->ask('Enter your database password', 'NULL');

                if($data['DB_MONGODB_PASSWORD'] == "NULL") $data['DB_MONGODB_PASSWORD'] = null;

            Config::set('database.connections.mongodb.host', $data['DB_MONGODB_HOST']);
            Config::set('database.connections.mongodb.port', $data['DB_MONGODB_PORT']);
            Config::set('database.connections.mongodb.database', $data['DB_MONGODB_DATABASE']);
            Config::set('database.connections.mongodb.username', $data['DB_MONGODB_USERNAME']);
            Config::set('database.connections.mongodb.password', $data['DB_MONGODB_PASSWORD']);

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
        }

    $this->_setData($data);
    return true;
    }
}
