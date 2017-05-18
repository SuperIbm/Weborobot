<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Repositories;

use Util;
use Carbon\Carbon;
use App\Models\RepositaryMongoDb;

/**
 * Класс репозитария статистики сайта на основе MongoDb.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SeoMongoDb extends Seo
{
use RepositaryMongoDb;

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
            ]
        );

        if($this->hasError() == false)
        {
            if($data)
            {
            $dataConvert = [];
            $dateGroupCurrent = "";
            $groupName = "";
            $firstDateShow = null;

                for($i = 0, $z = -1; $i < count($data); $i++)
                {
                    if($detalization == 'По дням')
                    {
                    $dateGroup = Carbon::createFromFormat('Y-m-d H:i:s', $data[$i]['dateStat'])->format('d-m-Y');
                    $groupName = "groupDays";
                    }
                    else if($detalization == 'По неделям')
                    {
                    $dateGroup = Carbon::createFromFormat('Y-m-d H:i:s', $data[$i]['dateStat'])->format('W-m-Y');
                    $groupName = "groupWeeks";
                    }
                    else if($detalization == 'За весь срок')
                    {
                    $dateGroup = 1;
                    $groupName = "groupAll";
                    }
                    else
                    {
                    $dateGroup = Carbon::createFromFormat('Y-m-d H:i:s', $data[$i]['dateStat'])->format('m-Y');
                    $groupName = "groupMonths";
                    }

                    if($dateGroupCurrent != $dateGroup)
                    {
                    $z++;

                    $dataConvert[$z] = $this->_sum([], $data[$i]);
                    $dateGroupCurrent = $dateGroup;

                    $dataConvert[$z]["dateGroup"] = $dateGroup;

                        if($detalization == 'За весь срок')
                        {
                            if(!$firstDateShow) $firstDateShow = Carbon::createFromFormat('Y-m-d H:i:s', $data[$i]['dateStat'])->format('d.m.Y');

                        $dataConvert[$z]["dateShow"] = $firstDateShow;
                        }
                        else $dataConvert[$z]["dateShow"] = Carbon::createFromFormat('Y-m-d H:i:s', $data[$i]['dateStat'])->format('d.m.Y');

                    $dataConvert[$z][$groupName] = $groupName;
                    }
                    else $dataConvert[$z] = $this->_sum($dataConvert[$z], $data[$i]);
                }

            $data = $dataConvert;
            }

        return $data == null ? [] : $data;
        }
        else return false;
    }


    /**
     * Суммирование статитстики.
     * @param array $dataCurrent Текущая статистика.
     * @param array $dataSum Статистика, которую нужно добавить.
     * @return array Результат суммирования.
     * @since 1.0
     * @version 1.0
     */
    private function _sum($dataCurrent, $dataSum)
    {
        foreach($dataSum as $k => $v)
        {
            if($k == "visits" || $k == "shows" || $k == "visitors" || $k == "visitorsNew")
            {
            $indexCount = "count".Util::ucfirst($k);

                if(!isset($dataCurrent[$k])) $dataCurrent[$k] = 0;
                if(!isset($dataCurrent[$indexCount])) $dataCurrent[$indexCount] = 0;

            $dataCurrent[$k] += $dataSum[$k];
            $dataCurrent[$indexCount] += $dataSum[$k];
            }
            else if($k != "_id") $dataCurrent[$k] = $dataSum[$k];
        }

    $dataCurrent["showsDeep"] = round($dataCurrent["countShows"] / $dataCurrent["countVisits"], 2);

    return $dataCurrent;
    }
}