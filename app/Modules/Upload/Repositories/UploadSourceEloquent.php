<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Repositories;

use App\Models\RepositaryEloquent;

/**
 * Класс репозитария источник обновления на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadSourceEloquent extends UploadSource
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
    return $this->_get(['Upload', 'UploadSourceItem'], $id, $active);
    }


    /**
     * Чтение данных.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read($filters = null, $active = null, $sorts = null, $offset = null, $limit = null)
    {
    return $this->_read(['Upload', 'UploadSourceItem'], false, $filters, $active, $sorts, $offset, $limit);
    }

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count($filters = null, $active = null)
    {
    return $this->_read(['Upload', 'UploadSourceItem'], true, $filters, $active);
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
    return $this->_create(['UploadSourceItem'], $data);
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
    return $this->_update(['UploadSourceItem'], $id, $data);
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
    return $this->_destroy(['UploadSourceItem'], $id);
    }


    /**
     * Получение всех правил обновлений.
     * Подключаеться ко всем источникам обновления и возвращает массив данных взятых с этих источников для дальнейшей их обработки.
     * @return array|bool Массив данных с разных источников. Если произошла ошибка выдаст false.
     * @since 1.0
     * @version 1.0
     */
    public function getRules()
    {
    $sources = $this->read(null, true);

        if($sources)
        {
        $rules = [];

            for($i = 0; $i < count($sources); $i++)
            {
                $urlArr = parse_url($sources[$i]["url"]);
                $query = "login=" . $sources[$i]["login"] . "&password=" . md5($sources[$i]["password"]) . "&time=" . time();

                if(isset($urlArr["query"])) $urlTo = $sources[$i]["url"] . "&" . $query;
                else $urlTo = $sources[$i]["url"] . "?" . $query;

            $ruleJson = @file_get_contents($urlTo);

                if($ruleJson)
                {
                $rule = @json_decode($ruleJson, true);

                    if($rule) $rules[] = $rule;
                    else
                    {
                    $this->addError("noUrl", "Некорректно составленный файл у ресурса ".$sources[$i]["url"]."!");
                    return false;
                    }
                }
                else
                {
                $this->addError("noUrl", "Указанный ресурс ".$sources[$i]["url"]." не был найден!");
                return false;
                }
            }

        return $rules;
        }
        else return [];
    }
}