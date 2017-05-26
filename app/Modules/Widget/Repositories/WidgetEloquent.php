<?php
/**
 * Модуль Виджеты.
 * Этот модуль содержит все классы для работы с виджетами.
 * @package App.Modules.Widget
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Widget\Repositories;

use Zip;
use Storage;
use Config;
use Util;
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария страницы на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class WidgetEloquent extends Widget
{
use RepositaryEloquent;

    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function get($id, $active = null)
    {
    return $this->_get(['Widget', 'WidgetItem'], $id, $active);
    }


    /**
     * Чтение данных.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $with Массив связанных моделей.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read($filters = null, $active = null, $sorts = null, $offset = null, $limit = null, $with = null)
    {
    return $this->_read(['Widget', 'WidgetItem'], false, $filters, $active, $sorts, $offset, $limit, $with);
    }

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $with Массив связанных моделей.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count($filters = null, $active = null, $with = null)
    {
    return $this->_read(['Widget', 'WidgetItem'], true, $filters, $active, null, null, null, $with);
    }

    /**
     * Создание.
     * @param array $data Данные для добавления.
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function create(array $data)
    {
    return $this->_create(['WidgetItem'], $data);
    }

    /**
     * Обновление.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function update($id, array $data)
    {
    return $this->_update(['WidgetItem'], $id, $data);
    }

    /**
     * Удаление.
     * @param int|array $id Id записи для удаления.
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function destroy($id)
    {
    return $this->_destroy(['WidgetItem'], $id);
    }

    /**
     * Установка виджета.
     * @param string $nameDir Папка модуля.
     * @param string $file Путь к файлу с архивом модуля.
     * @return bool Вернет true, если установка прошла успешно.
     * @since 1.0
     * @version 1.0
     */
    public function install($nameDir, $file)
    {
    $pathToDir = Storage::disk('modules')->getDriver()->getAdapter()->applyPathPrefix($nameDir.'/');
    $nameDirLower = Util::toLower($nameDir);

    Zip::setFile($file);
    Zip::extract(PCLZIP_OPT_PATH, $pathToDir);

        if(Zip::errorCode() == 0)
        {
        Config::set($nameDir, require $pathToDir.'Config/config.php');

            if(Util::isCorrectVersion(Config::get('app.version'), Config::get($nameDirLower.'.version')))
            {
                $module = $this->read
                (
                    [
                        [
                        'property' => 'nameModule',
                        'value' => Config::get($nameDirLower.'.name')
                        ]
                    ]
                );

                if($module)
                {
                    if(Config::get($nameDirLower.'.widgets'))
                    {
                    $widgets = Config::get($nameDirLower.'.widgets');

                        for($i = 0; $i < count($widgets); $i++)
                        {
                            $this->create
                            (
                                [
                                'idModule' => $module[0]['idModule'],
                                'actionWidget' => $widgets[$i]['actionWidget'],
                                'labelWidget' => $widgets[$i]['labelWidget'],
                                'icon' => $widgets[$i]['icon'],
                                'pathToCss' => isset($widgets[$i]['pathToCss']) ? $widgets[$i]['pathToCss'] : null,
                                'pathToJs' => $widgets[$i]['pathToJs'],
                                'def' => $widgets[$i]['def'],
                                'status' => 'Активен'
                                ]
                            );
                        }
                    }

                return true;
                }
                else
                {
                $this->addError('noModule', 'Модуль '.Config::get($nameDirLower.'.label').' в системе не обнаружен.');
                return false;
                }
            }
            else
            {
            $this->addError('isNotCorrectVersion', 'Данная версия модуля не подходит под текущую версию системы.');
            return false;
            }
        }
        else
        {
        $this->addError('isNoCorrectArchive', 'Некорректный архив модуля.');
        return false;
        }
    }
}