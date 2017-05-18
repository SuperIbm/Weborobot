<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Repositories;

use App\Models\Repositary;

/**
 * Абстрактный класс построения источник репозитария для обновления.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class UploadSource extends Repositary
{
    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function get($id, $active = null);

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
    abstract public function read($filters = null, $active = null, $sorts = null, $offset = null, $limit = null);

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    abstract public function count($filters = null, $active = null);

    /**
     * Создание.
     * @param array $data Данные для добавления.
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract public function create(array $data);

    /**
     * Обновление.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract public function update($id, array $data);

    /**
     * Удаление.
     * @param int|array $id Id записи для удаления.
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy($id);


    /**
     * Получение всех правил обновлений.
     * Подключаеться ко всем источникам обновления и возвращает массив данных взятых с этих источников для дальнейшей их обработки.
     * @return array Массив данных с разных источников.
     * @since 1.0
     * @version 1.0
     */
    abstract public function getRules();
}