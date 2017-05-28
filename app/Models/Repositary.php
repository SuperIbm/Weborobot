<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;


/**
 * Абстрактный класс репозитария, для построения собственных репозитариев.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Repositary
{
use Error;

/**
 * Модель данного репозитацрия.
 * @var Object
 * @version 1.0
 * @since 1.0
 */
private $_Model;

/**
 * Количество минут на сколько должен сохранятся кешь.
 * @var int
 * @version 1.0
 * @since 1.0
 */
private $_cacheMinutes = 60;

    /**
     * Конструктор.
     * @param object $Model Модель данного репозитария.
     * @since 1.0
     * @version 1.0
     */
    public function __construct($Model)
    {
    $this->_setModel($Model);
    }

    /**
     * Получение модели этого репозитария.
     * @return object Модель данного репозитария.
     * @since 1.0
     * @version 1.0
     */
    public function getModel()
    {
    return $this->_Model;
    }

    /**
     * Уствнока модели этого репозитария.
     * @param object $Model Модель данного репозитария.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    protected function _setModel($Model)
    {
    $this->_Model = $Model;
    return $this;
    }

    /**
     * Получение количество минут на сколько должен сохранятся кешь.
     * @return int Количество минут.
     * @since 1.0
     * @version 1.0
     */
    public function getCacheMinutes()
    {
    return $this->_cacheMinutes;
    }

    /**
     * Установка количества минут на сколько должен сохранятся кешь.
     * @param int $minutes Количество минут.
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setCacheMinutes($minutes)
    {
    $this->_cacheMinutes = $minutes;
    return $this;
    }

    /**
     * Перевод ключ значение к формату репозитария для сортировки данных.
     * @param array $sorts Массив значений для фильтрации.
     * @param array $allows Массив допустимых колонок, которые могут сортироваться в данной таблице.
     * @param string $table Название таблицы для сортировки.
     * @return array Преобразованный массив сортировки для репозитариев.
     * @since 1.0
     * @version 1.0
     */
    static public function sorts($sorts, $allows, $table)
    {
        for($i = 0; $i < count($sorts); $i++)
        {
            if(in_array($sorts[$i]['property'], $allows))
            {
            $sorts[$i]['property'] = $table.'.'.$sorts[$i]['property'];
            }
        }

    return $sorts;
    }


    /**
     * Перевод ключ значение к формату репозитария для филтрации данных.
     * @param array $filters Массив значений для фильтрации.
     * @param array $allows Массив допустимых параметров.
     * @param array $table Название таблицы для колонок фильтрации.
     * @return array Преобразованный массив фильтрации для репозитариев.
     * @since 1.0
     * @version 1.0
     */
    static public function filters($filters, $allows = null, $table = null)
    {
        for($i = 0; $i < count($filters); $i++)
        {
            if(isset($filters[$i]['operator']))
            {
                if($filters[$i]['operator'] == "==") $filters[$i]["operator"] = "=";
                if($filters[$i]['operator'] == "lt") $filters[$i]["operator"] = ">";
                if($filters[$i]['operator'] == "gt") $filters[$i]["operator"] = "<";
                if($filters[$i]['operator'] == "eq") $filters[$i]["operator"] = "=";
                if($filters[$i]['operator'] == "in") $filters[$i]["operator"] = "=";
                if($filters[$i]['operator'] == "like") $filters[$i]["value"] = "%".$filters[$i]["value"]."%";
            }
        }

        if($allows)
        {
        $filtersNew = [];

            for($i = 0, $z = 0; $i < count($filters); $i++)
            {
                if(in_array($filters[$i]['property'], $allows))
                {
                $filtersNew[$z] = $filters[$i];

                    if($table) $filtersNew[$i]['property'] = $table.'.'.$filtersNew[$i]['property'];

                $z++;
                }
            }

        $filters = $filtersNew;
        }

    return $filters;
    }

    /**
     * Получить по первичному ключу.
     * @param array $tags Массив тэгов для кеширования.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _get($tags, $id, $active = null);

    /**
     * Чтение данных.
     * @param array $tags Массив тэгов для кеширования.
     * @param bool $count Вернуть только количество записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $with Массив связанных моделей.
     * @param array $group Массив для группировки.
     * @param array|string $selects Выражения для выборки.
     * @return array|int Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _read
    (
        $tags,
        $count = false,
        $filters = null,
        $active = null,
        $sorts = null,
        $offset = null,
        $limit = null,
        $with = null,
        $group = null,
        $selects = null
    );


    /**
     * Создание.
     * @param array $data Данные для добавления.
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _create($tags, array $data);

    /**
     * Обновление.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _update($tags, $id, array $data);

    /**
     * Удаление.
     * @param int|array $id Id записи для удаления.
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _destroy($tags, $id);


    /**
     * Получение нового экземпляра модели.
     * @param array $data Данные этой модели.
     * @param bool $exists Определяет существует ли эта запись или нет.
     * @return \App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent Объект модели данного репозитария.
     * @since 1.0
     * @version 1.0
     */
    abstract public function newInstance(array $data = array(), $exists = false);
}
?>