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
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария статистики сайта на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SeoEloquent extends Seo
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
    return $this->_get(['Seo', 'SeoItem'], $id);
    }


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
    public function read($filters = null, $sorts = null, $offset = null, $limit = null, $group = null, $selects = null)
    {
    return $this->_read(['Seo', 'SeoItem'], false, $filters, null, $sorts, $offset, $limit, null, $group, $selects);
    }

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count($filters = null)
    {
    return $this->_read(['Seo', 'SeoItem'], true, $filters);
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
    return $this->_create(['SeoItem'], $data);
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
    return $this->_update(['SeoItem'], $id, $data);
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
    return $this->_destroy(['SeoItem'], $id);
    }

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
    public function take($detalization, $date = null, Carbon $DateFrom = null, Carbon $DateTo = null)
    {
    $filters = [];

        $selects =
        [
        'seo.*',
        'SUM(visits) AS countVisits',
        'SUM(shows) AS countShows',
        'SUM(visitors) AS countVisitors',
        'SUM(visitorsNew) AS countVisitorsNew',
        'ROUND(SUM(shows) / SUM(visits), 2) AS showsDeep'
        ];

        if($detalization == 'По дням')
        {
        $selects[] = "DATE_FORMAT(dateStat, '%d-%m-%Y') AS dateGroup";
        $selects[] = "'groupDays'";
        $selects[] = "DATE_FORMAT(dateStat, '%d.%m.%Y') AS dateShow";
        }
        else if($detalization == 'По неделям')
        {
        $selects[] = "DATE_FORMAT(dateStat, '%v-%m-%Y') AS dateGroup";
        $selects[] = "'groupWeeks'";
        $selects[] = "DATE_FORMAT(dateStat, '%d.%m.%Y') AS dateShow";
        }
        else if($detalization == 'За весь срок')
        {
        $selects[] = "MIN(dateStat) AS dateStat";
        $selects[] = "1 AS dateGroup";
        $selects[] = "'groupAll'";
        $selects[] = "DATE_FORMAT(MIN(dateStat), '%d.%m.%Y') AS dateShow";
        }
        else
        {
        $selects[] = "DATE_FORMAT(dateStat, '%m-%Y') AS dateGroup";
        $selects[] = "'groupMonths'";
        $selects[] = "DATE_FORMAT(dateStat, '%d.%m.%Y') AS dateShow";
        }

        if($date == "Сегодня")
        {
        $DateFrom = Carbon::now();
        $DateTo = Carbon::now();
        }
        else if($date == "Вчера")
        {
        $DateFrom = Carbon::yesterday();
        $DateTo = Carbon::yesterday();
        }
        else if($date == "Неделя")
        {
        $DateFrom = Carbon::now()->subWeek();
        $DateTo = Carbon::now();
        }
        else if($date == "Месяц")
        {
        $DateFrom = Carbon::now()->subMonth();
        $DateTo = Carbon::now();
        }
        else if($date == "Квартал")
        {
        $DateFrom = Carbon::now()->subQuarter();
        $DateTo = Carbon::now();
        }
        else if($date == "Год")
        {
        $DateFrom = Carbon::now()->subYear();
        $DateTo = Carbon::now();
        }

        if(isset($DateFrom))
        {
            $DateFrom
            ->hour(0)
            ->minute(0)
            ->second(0);

            $filters[] =
            [
            'property' => 'dateStat',
            'operator' => '>=',
            'value' => $DateFrom
            ];
        }

        if(isset($DateTo))
        {
            $DateTo
            ->hour(0)
            ->minute(0)
            ->second(0);

            $filters[] =
            [
            'property' => 'dateStat',
            'operator' => '<=',
            'value' => $DateTo
            ];
        }

        $data = $this->read
        (
            $filters,
            [
                [
                'property' => 'dateStat',
                'direction' => 'ASC'
                ]
            ],
            null,
            null,
            [
            'dateGroup',
            'idSeo'
            ],
            $selects
        );

        if($this->hasError() == false) return $data == null ? [] : $data;
        else return false;
    }
}