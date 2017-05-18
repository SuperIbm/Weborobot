<?php
/**
 * Модуль Компонента страницы.
 * Этот модуль содержит все классы для работы с компонентами страницы.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponent\Repositories;

use App\Models\RepositaryEloquent;
use App;
use Cache;

/**
 * Класс репозитария компонетов страницы в виде древовидной структуры выдающий массив на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageComponentTreeArrayEloquent extends PageComponentTreeArray
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
    return App::make('App\Modules\PageComponent\Repositories\PageComponent')->get($id);
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
	return App::make('App\Modules\PageComponent\Repositories\PageComponent')->read($filters, $sorts, $offset, $limit, $with);
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
    return App::make('App\Modules\PageComponent\Repositories\PageComponent')->count($filters, $with);
    }

	/**
	 * Создание.
	 * @param array $data Данные для добавления.
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @since 1.0
	 * @version 1.0
	 */
	public function create(array $data, $filters = null)
	{
	$Model = $this->newInstance();
	$idPageComponent = $Model->createNode($data, $filters);

        if($Model->hasError())
		{
		$this->addError($Model->getErrors());
		return false;
		}
		else Cache::tags(['PageComponentItem'])->flush();

	return $idPageComponent;
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
    $Model = App::make('App\Modules\PageComponent\Repositories\PageComponent');
    $id = $Model->update($id, $data);

        if($Model->hasError()) $this->addError($Model->getErrors());

    return $id;
	}

	/**
	 * Удаление.
	 * @param int|array $id Id записи для удаления.
	 * @param bool $deleteChildren Определяет нужно ли производить удаление внутренних узлов.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Вернет булево значение успешности операции.
	 * @since 1.0
	 * @version 1.0
	 */
	public function destroy($id, $deleteChildren = true, $filters = null)
	{
	$Model = $this->newInstance();
	$status = $Model->destroyNode($id, $deleteChildren, $filters);

		if($status == false) $this->addError($Model->getErrors());
		else Cache::tags(['PageComponentItem'])->flush();

	return $status;
	}

	/**
	 * Получение нового экземпляра модели.
	 * @param array $data Данные этой модели.
	 * @param bool $exists Определяет существует ли эта запись или нет.
	 * @return \App\Modules\PageComponent\Models\PageComponentTreeArrayEloquent Объект модели данного репозитария.
	 * @since 1.0
	 * @version 1.0
	 */
	public function newInstance(array $data = array(), $exists = false)
	{
	$Model = $this->getModel()->newInstance($data, $exists);

		if($exists && isset($data['idPageComponent'])) $Model->idPageComponent = $data['idPageComponent'];

	return $Model;
	}


	/**
	 * Чтение данных и получение их в виде древовидной структуры.
	 * @param array $data Данные для построения дерева.
	 * @param bool $isOpenType Определяем является ли эта закрытая или открытая древовидная структура.
	 * @param int $idCurrent ID корень текущей ветки.
	 * @param int $idRoot ID корень ветки.
	 * @param int $idReferenRoot ID ссылки узла для установки корня ветки.
     * @param array $params Параметры для узла.
	 * @return array Построенное дерево.
	 * @since 1.0
	 * @version 1.0
	 */
	public function tree($data, $isOpenType = true, $idCurrent = null, $idRoot = null, $idReferenRoot = null, $params = null)
	{
		$cacheKey = md5
		(
			serialize($data)
			.serialize($isOpenType)
			.serialize($idCurrent)
			.serialize($idRoot)
			.serialize($idReferenRoot)
            .serialize($params)
		);

		return Cache::tags(['PageComponent', 'PageComponentItem', 'PageComponentTreeArray'])->remember($cacheKey, $this->getCacheMinutes(),
			function() use ($data, $isOpenType, $idCurrent, $idRoot, $idReferenRoot, $params)
			{
			$Model = $this->newInstance();
			$Model->isOpenType($isOpenType);
            $Model->getNode()->setParams($params);

				if($idRoot) $Model->setIdRoot($idRoot);
				else if($idReferenRoot) $Model->setReferenRoot($idReferenRoot);

				if($idCurrent) $Model->setIdCurrent($idCurrent);

			return $Model->tree($data);
			}
		);
	}


	/**
	 * Установка нового веса узла в древовидной структуре.
	 * @param int $id ID узла, который нужно переместить.
	 * @param int $weight Новый вес узла.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function setWeight($id, $weight, $filters = null)
	{
	$Model = $this->newInstance()->find($id);

		if($Model)
		{
		$status = $Model->setWeight($weight, null, $filters);

			if(!$status) $this->addError($Model->getErrors());
			else Cache::tags(['PageComponentItem'])->flush();

		return $status;
		}
		else return false;
	}


	/**
	 * Установка нового положение узла в древовидной структуре.
	 * @param int $id ID узла, который нужно переместить.
	 * @param int $idReferenNew ID узла, которому должен принадлежал этот узел.
     * @param array $filters Фильтрация записей, которые не должны рассматриваться в процессе перестановки узлов.
	 * @return bool Возвращает успешность перемещения.
	 * @since 1.0
	 * @version 1.0
	 */
	public function setPosition($id, $idReferenNew, $filters = null)
	{
	$Model = $this->newInstance()->find($id);

		if($Model)
		{
			$status = $Model->setPosition($idReferenNew, null, $filters);

			if(!$status) $this->addError($Model->getErrors());
			else Cache::tags(['PageComponentItem'])->flush();

			return $status;
		}
		else return false;
	}
}