<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use Config;
use App\Models\Decorator;

/**
 * Запуск проверки была ли уже установлена система или нет.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerProtect extends Decorator
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
    return "protect";
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
        if(Config::get('app.installed') == true)
        {
        /**
         * @var $Root \App\Modules\Core\Models\Installer
         */
        $Root = $this->getRootDecorator();
        $Root->getCommand()->error('System has already been installed. You can already log into your administration.');

        return false;
        }
        else $this->_setData(['APP_INSTALLED' => true]);

    return true;
    }
}
