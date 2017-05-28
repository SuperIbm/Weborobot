<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use App\Models\Decorator;
use Illuminate\Console\Command;

/**
 * Класс установщик, позволяет установить систему.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Installer extends Decorator
{
/**
 * Консоль.
 * @var \Illuminate\Console\Command
 * @version 1.0
 * @since 1.0
 */
private $_Command;


    /**
     * Метод получения индекса.
     * Этот индекс используется в массиве данных для сохранения тех данных, которые были созданы этим декоратором.
     * @return string Название индекса.
     * @since 1.0
     * @version 1.0
     */
    public function getIndex()
    {
    return "installer";
    }


    /**
     * Запуск инсталяции системы.
     * @param array $params Параметры декоратора.
     * @param \App\Models\Decorator $ParentDecorator Родительский декоратор.
     * @return bool Должен вернуть true если действие выполнено успешно.
     * @since 1.0
     * @version 1.0
     */
    protected function _action($params, Decorator $ParentDecorator = null)
    {
    return true;
    }

    /**
     * Метод обработчик собития после выполнения всех действий декоратора.
     * @return bool Должен вернуть true, для успешности действия.
     * @since 1.0
     * @version 1.0
     */
    public function afterAction()
    {
    $this->getCommand()->info('The system has been successfully installed.');
    $this->getCommand()->info('You can now login with your username and password at /admin.');
    return true;
    }

    /**
     * Установка консоли.
     * @param \Illuminate\Console\Command $Command Консоль.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setCommand(Command $Command)
    {
    $this->_Command = $Command;
    return $this;
    }


    /**
     * Установка консоли.
     * @return \Illuminate\Console\Command $Command Консоль.
     * @since 1.0
     * @version 1.0
     */
    public function getCommand()
    {
    return $this->_Command;
    }
}
