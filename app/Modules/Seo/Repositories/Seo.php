<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Repositories;

use Carbon\Carbon;
use App\Models\Repositary;

/**
 * Абстрактный класс построения репозитария для статистики сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Seo extends Repositary
{
    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function get($id);

    /**
     * Чтение данных.
     * @param array $filters Фильтрация данных.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $group Массив для группировки.
     * @param array|string $selects Выражения для выборки.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function read($filters = null, $sorts = null, $offset = null, $limit = null, $group = null, $selects = null);

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    abstract public function count($filters = null);

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
     * Получить статистику согласно заданным параметрам.
     * @param string $detalization Детализация: По дням, По неделям, За весь срок, По месяцам.
     * @param string $date Период: Сегодня, Вчера, Неделя, Месяц, Квартал, Год.
     * @param \Carbon\Carbon $DateFrom Начальая дата статистики.
     * @param \Carbon\Carbon $DateTo Конечная дата статистики.
     * @return array|bool Массив данных статистики.
     * @since 1.0
     * @version 1.0
     */
    abstract public function take($detalization, $date = null, Carbon $DateFrom = null, Carbon $DateTo = null);
}