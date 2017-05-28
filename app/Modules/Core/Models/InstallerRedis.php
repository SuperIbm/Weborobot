<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use Redis;
use Config;
use App\Models\Decorator;
use PDOException;

/**
 * Запуск установки конфигурации базы данных Redis.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerRedis extends Decorator
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
    return "redis";
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
        'REDIS_HOST' => '',
        'REDIS_PORT' => '',
        'REDIS_DATABASE' => '',
        'REDIS_PASSWORD' => '',
        'REDIS_CLUSTER' => ''
        ];

    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();

        if($Root->getCommand()->confirm('Would you like setting Redis for your system? [Y|N]', false))
        {
            while(!$connected)
            {
            /**
             * @var $Root \App\Modules\Core\Models\Installer
             */
            $data['REDIS_HOST'] = $Root->getCommand()->ask('Enter your database host', 'localhost');
            $data['REDIS_PORT'] = $Root->getCommand()->ask('Enter your port', '27017');
            $data['REDIS_DATABASE'] = $Root->getCommand()->ask('Enter your database name', 0);
            $data['REDIS_PASSWORD'] = $Root->getCommand()->ask('Enter your database password', 'NULL');

                if($data['REDIS_PASSWORD'] == "NULL") $data['REDIS_PASSWORD'] = null;

            $data['REDIS_CLUSTER'] = $Root->getCommand()->confirm('Would you like using cluster system? [Y|N]', false);

            Config::set('database.redis.cluster', $data['REDIS_CLUSTER']);
            Config::set('database.redis.default.host', $data['REDIS_HOST']);
            Config::set('database.redis.default.port', $data['REDIS_PORT']);
            Config::set('database.redis.default.database', $data['REDIS_DATABASE']);
            Config::set('database.redis.default.password', $data['REDIS_PASSWORD']);

                try
                {
                Redis::connection();
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
