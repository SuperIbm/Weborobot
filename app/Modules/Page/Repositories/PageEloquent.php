<?php
/**
 * Модуль Страницы сайта.
 * Этот модуль содержит все классы для работы со страницами сайта.
 * @package App.Modules.Page
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Page\Repositories;

use Cache;
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария страницы на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageEloquent extends Page
{
use RepositaryEloquent;

    /**
     * Получить по первичному ключу.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param bool $inherit Требуется ли взять зависмости у вышестоящих страниц.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function get($id, $active = null, $inherit = false)
    {
    $page = $this->_getById($id, $active, $inherit);

        if($page) return $page;
        else
        {
            $pages = $this->read
            (
                [
                    [
                    'property' => $this->getModel()->getKeyName(),
                    'value' => $id
                    ]
                ],
                $active,
                null,
                null,
                null,
                $inherit
            );

            if($pages)
            {
            $this->_setById($id, $pages[0], $inherit);
            return $pages[0];
            }
            else return null;
        }
    }

	/**
	 * Чтение данных.
	 * @param array $filters Фильтрация данных.
	 * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
	 * @param bool $inherit Требуется ли взять зависмости у вышестоящих страниц.
	 * @return array Массив данных.
	 * @since 1.0
	 * @version 1.0
	 */
	public function read($filters = null, $active = null, $sorts = null, $offset = null, $limit = null, $inherit = false)
	{
	$Query = $this->newInstance()->newQuery();

		if($filters)
		{
			for($i = 0; $i < count($filters); $i++)
			{
			$Query->where($filters[$i]['property'], !isset($filters[$i]['operator']) ? "=" : $filters[$i]['operator'], $filters[$i]['value']);
			}
		}

		if(isset($active)) $Query->active();

        if($sorts)
        {
            for($i = 0; $i < count($sorts); $i++)
            {
            $Query->orderBy($sorts[$i]['property'], $sorts[$i]['direction']);
            }
        }

        if($offset) $Query->offset($offset);
        if($limit) $Query->limit($limit);

	$cacheKeyInherit = $inherit == true ? "inherit" : "noInherit";
	$cacheKey = md5($Query->getConnection()->getName().$Query->toSql().serialize($Query->getBindings()).$cacheKeyInherit);

		$data = Cache::tags(['Page', 'PageItem'])->remember($cacheKey, $this->getCacheMinutes(),
			function() use ($Query, $inherit)
			{
				if($inherit == true)
				{
				$pages = $Query->get()->toArray();

					for($i = 0; $i < count($pages); $i++)
					{
					$pages[$i] = $this->_getInherit($pages[$i]);
					}

				return $pages;
				}
				else return $Query->get()->toArray();
			}
		);

		if($data) return $data;
		else return null;
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
    return $this->_create(['PageItem'], $data);
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
    return $this->_update(['PageItem'], $id, $data);
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
    return $this->_destroy(['PageItem'], $id);
    }
}