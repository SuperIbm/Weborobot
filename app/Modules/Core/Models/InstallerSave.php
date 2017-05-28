<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use Storage;
use App\Models\Decorator;


/**
 * Запуск записи всех полученных значений в файл .env.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerSave extends Decorator
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
    return "save";
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
    $data = $this->getRootDecorator()->getData('array');
    Storage::disk('root')->put('/.env', '');

        foreach($data as $k => $v)
        {
            foreach($data[$k] as $k2 => $v2)
            {
            Storage::disk('root')->append('/.env', $k2.'='.$v2);
            }
        }

    return true;
    }
}
