<?php
/**
 * Модуль Компонента.
 * Этот модуль содержит все классы для работы с компонентами системы.
 * @package App.Modules.Component
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Component\Repositories;

use Zip;
use Storage;
use Config;
use Util;
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария компонента на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ComponentEloquent extends Component
{
use RepositaryEloquent;

    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function get($id)
    {
    return $this->_get(['Component', 'ComponentItem'], $id);
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
    return $this->_read(['Component', 'ComponentItem'], false, $filters, $active, $sorts, $offset, $limit, $with);
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
    return $this->_read(['Component', 'ComponentItem'], true, $filters, $active, null, null, null, $with);
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
    return $this->_create(['ComponentItem'], $data);
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
    return $this->_update(['ComponentItem'], $id, $data);
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
    return $this->_destroy(['ComponentItem'], $id);
    }

    /**
     * Установка компонента.
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
        Config::set($nameDirLower, require $pathToDir.'Config/config.php');

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
                    if(Config::get($nameDirLower.'.components'))
                    {
                    $components =  Config::get($nameDirLower.'.components');

                        for($i = 0; $i < count($components); $i++)
                        {
                            $this->create
                            (
                                [
                                'idModule' => $module[0]['idModule'],
                                'nameBundle' => isset($components[$i]['nameBundle']) ? $components[$i]['nameBundle'] : null,
                                'nameComponent' => $components[$i]['nameComponent'],
                                'labelComponent' => $components[$i]['labelComponent'],
                                'pathToCss' => isset($components[$i]['pathToCss']) ? $components[$i]['pathToCss'] : null,
                                'pathToJs' => isset($components[$i]['pathToJs']) ? $components[$i]['pathToJs'] : null,
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