<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 * @package App.Modules.User
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\User\Repositories;

use App\Models\RepositaryEloquent;

/**
 * Класс репозитария выбранных разделов роли на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRoleAdminSectionEloquent extends UserRoleAdminSection
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
    return $this->_get(['User', 'UserRoleAdminSection'], $id);
    }


    /**
     * Чтение данных.
     * @param array $filters Фильтрация данных.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $with Массив связанных моделей.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read($filters = null, $sorts = null, $offset = null, $limit = null, $with = null)
    {
    return $this->_read(['User', 'UserRoleAdminSection'], false, $filters, null, $sorts, $offset, $limit, $with);
    }

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param array $with Массив связанных моделей.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count($filters = null, $with = null)
    {
    return $this->_read(['User', 'UserRoleAdminSection'], true, $filters, null, null, null, null, $with);
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
    return $this->_create(['UserRoleAdminSection'], $data);
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
    return $this->_update(['UserRoleAdminSection'], $id, $data);
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
    return $this->_destroy(['UserRoleAdminSection'], $id);
    }
}