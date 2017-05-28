<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use App;
use Config;
use App\Models\Decorator;

/**
 * Запуск установки конфигурации ключа для шифрования в системе.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerAppKey extends Decorator
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
    return "appKey";
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
    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();
    $Root->getCommand()->call('key:generate');
    $User = App::make('App\Modules\User\Repositories\User');

    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();

        $User->update(1,
            [
            'login' => $Root->getCommand()->ask('Enter your admin login', 'admin'),
            'password' => $Root->getCommand()->ask('Enter your admin password', '123456')
            ]
        );

        $this->_setData
        (
           [
           'APP_KEY' => Config::get('app.key')
           ]
        );

    return true;
    }
}
