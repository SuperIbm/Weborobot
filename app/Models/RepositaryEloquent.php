<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;

use DB;
use Util;
use Cache;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;


/**
 * Трейт репозитария работающий с Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait RepositaryEloquent
{
    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    protected function _get($tags, $id, $active = null)
    {
        $pages = $this->_read
        (
        $tags,
            false,
            [
                [
                'property' => $this->getModel()->getKeyName(),
                'value' => $id
                ]
            ],
        $active
        );

        if($pages) return $pages[0];
        else return null;
    }


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
    protected function _read
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
    )
    {
    $Query = $this->newInstance()->newQuery();

        if($selects)
        {
        $queryStrRawSelect = "";

            if(!is_array($selects)) $selects = [$selects];

            for($i = 0; $i < count($selects); $i++)
            {
                if($queryStrRawSelect != "") $queryStrRawSelect .= ", ";

                $queryStrRawSelect .= $selects[$i];
            }

        $Query->select(DB::raw($queryStrRawSelect));
        }

        if($filters)
        {
        $fils = self::filters($filters, $this->newInstance()->getFillable(), $Query->getModel()->getTable());

            for($i = 0; $i < count($fils); $i++)
            {
            $Query->where($fils[$i]['property'], !isset($fils[$i]['operator']) ? "=" : $fils[$i]['operator'], $fils[$i]['value']);
            }
        }

        if(isset($active)) $Query->active();
        if($sorts) $sorts = self::sorts($sorts, $this->newInstance()->getFillable(), $Query->getModel()->getTable());

        if($with)
        {
            for($i = 0; $i < count($with); $i++)
            {
            $name = Util::toLower($with[$i]);
            $ModelRelated = $Query->getModel()->$name()->getRelated();
            $fillables = $ModelRelated->getFillable();
            $fils = self::filters($filters, $fillables, $ModelRelated->getTable());
            $sorts = self::sorts($sorts, $fillables, $ModelRelated->getTable());

            $Query->with($name);

                if($fils)
                {
                    $Query->whereHas
                    (
                        $with[$i],
                        function($Query) use ($fils)
                        {
                            for($i = 0; $i < count($fils); $i++)
                            {
                            $Query->where($fils[$i]['property'], !isset($fils[$i]['operator']) ? "=" : $fils[$i]['operator'], $fils[$i]['value']);
                            }
                        }
                    );
                }

                if($sorts)
                {
                $Relation = $Query->getModel()->$name();
                $Related = $Relation->getRelated();
                $tableForeign = $Related->getTable();
                $kyeOwner = null;
                $keyForeign = null;

                    if($Relation instanceof HasOneOrMany)
                    {
                    $kyeOwner = $Relation->getQualifiedParentKeyName();
                    $keyForeign = $Relation->getForeignKey();
                    }
                    else if($Relation instanceof BelongsTo)
                    {
                    $kyeOwner = $Relation->getQualifiedForeignKey();
                    $keyForeign = $tableForeign.'.'.$Relation->getOtherKey();
                    }

                    if(isset($kyeOwner) && isset($keyForeign))
                    {
                        $Query->join
                        (
                        $tableForeign,
                        $kyeOwner,
                        $keyForeign
                        );
                    }

                $Query->select(DB::raw($Query->getModel()->getTable().".*"));
                }
            }
        }

        if($sorts)
        {
            for($i = 0; $i < count($sorts); $i++)
            {
            $Query->orderBy($sorts[$i]['property'], $sorts[$i]['direction']);
            }
        }

        if($offset) $Query->offset($offset);
        if($limit) $Query->limit($limit);
        if($group) $Query->groupBy($group);

    $countString = $count == true ? 'count' : 'rows';
    $cacheKey = md5($Query->getConnection()->getName().$Query->toSql().serialize($Query->getBindings()).$countString.serialize($with));

        $data = Cache::tags($tags)->remember($cacheKey, $this->getCacheMinutes(),
            function() use ($Query, $count)
            {
                if($count) return $Query->count();
                else return $Query->get()->toArray();
            }
        );

        if($data) return $data;
        else if($count) return 0;
        else return null;
    }


    /**
     * Создание.
     * @param array $data Данные для добавления.
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    protected function _create($tags, array $data)
    {
    $Model = $this->newInstance();
    unset($data[$Model->getKeyName()]);

        foreach($data as $k => $v)
        {
            if($data[$k] === "") unset($data[$k]);
        }

    $Model = $Model->create($data);

        if($Model->hasError())
        {
        $this->addError($Model->getErrors());
        return false;
        }
        else Cache::tags($tags)->flush();

    return $Model->getKey();
    }

    /**
     * Обновление.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    protected function _update($tags, $id, array $data)
    {
    $Model = $this->newInstance()->find($id);

        if($Model)
        {
        $status = $Model->update($data);

            if($Model->hasError() == true || $status == false)
            {
            $this->addError($Model->getErrors());
            return false;
            }
            else Cache::tags($tags)->flush();

        return $id;
        }
        else return false;
    }

    /**
     * Удаление.
     * @param int|array $id Id записи для удаления.
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    protected function _destroy($tags, $id)
    {
    $Model = $this->newInstance();
    $status = $Model->destroy($id);

        if(!$status) $this->addError($Model->getErrors());
        else Cache::tags($tags)->flush();

    return $status;
    }


    /**
     * Получение нового экземпляра модели.
     * @param array $data Данные этой модели.
     * @param bool $exists Определяет существует ли эта запись или нет.
     * @return \App\Modules\ModuleTemplate\Models\ModuleTemplateEloquent Объект модели данного репозитария.
     * @since 1.0
     * @version 1.0
     */
    public function newInstance(array $data = array(), $exists = false)
    {
    $Model = $this->getModel()->newInstance($data, $exists);

        if($exists && isset($data[$Model->getKeyName()])) $Model->{$Model->getKeyName()} = $data[$Model->getKeyName()];

    return $Model;
    }
}
?>