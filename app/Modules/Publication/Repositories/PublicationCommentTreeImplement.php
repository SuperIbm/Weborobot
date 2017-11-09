<?php
/**
 * Модуль Публикации.
 * Этот модуль содержит все классы для работы с публикациями.
 * @package App.Modules.Publication
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Publication\Repositories;

use App;
use Cache;
use App\Models\RepositaryEloquent;

/**
 * Стандартная реализация класса репозитария комментариве для древовидной структуры.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait PublicationCommentTreeImplement
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
    return App::make('App\Modules\Publication\Repositories\PublicationComment')->get($id, $active);
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
    return App::make('App\Modules\Publication\Repositories\PublicationComment')->read($filters, $active, $sorts, $offset, $limit, $with);
    }

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $with Массив связанных моделей.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count($filters = null, $active = null, $with = null)
    {
    return App::make('App\Modules\Publication\Repositories\PublicationComment')->count($filters, $active, $with);
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
    $idPage = $Model->createNode($data, $filters);

        if($Model->hasError())
        {
        $this->addError($Model->getErrors());
        return false;
        }
        else Cache::tags(['PublicationComment'])->flush();

    return $idPage;
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
    $Model = App::make('App\Modules\Publication\Repositories\PublicationComment');
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
        else Cache::tags(['PublicationComment'])->flush();

        return $status;
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

        return Cache::tags(['Publication', 'PublicationComment'])->remember($cacheKey, $this->getCacheMinutes(),
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
            else Cache::tags(['PublicationComment'])->flush();

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
            else Cache::tags(['PublicationComment'])->flush();

            return $status;
        }
        else return false;
    }


    /**
     * Получение пути от заданного корня до последней ветки.
     * Получаем путь в виде массива, где началом служит заданный корень, а концом служит конечная ветка.
     * @param array $data Данные полученные с выборки для построения пути.
     * @param int $idRoot ID корня ветки, с которой мы идем.
     * @param string $columnValue Название столбца с которого берется значение, если не указать будет брать весь массив данных узла.
     * @return mixed Массив пути от заданного корня до последней ветки.
     * @since 1.0
     * @version 1.0
     */
    public function getPathByRoot($data, $idRoot = null, $columnValue = null)
    {
    return $this->newInstance()->getPathByRoot($idRoot, $columnValue, $data);
    }


    /**
     * Получение пути от заданной ветки до заданного корня.
     * Получаем путь в виде массива, где началом служит заданная ветка, а концом служит заданный корень.
     * @param array $data Данные полученные с выборки для построения пути.
     * @param int $id ID ветки, от которой мы идем.
     * @param int $idRoot ID корня ветки, до которого мы идем.
     * @param string $columnValue Название столбца, который будет служить для именования узлов, если не указать будет брать весь массив данных узла.
     * @return mixed Массив пути от ветки до заданного корня.
     * @since 1.0
     * @version 1.0
     */
    public function getPath($data, $id, $idRoot = null, $columnValue = null)
    {
    return $this->newInstance()->getPath($id, $idRoot, $columnValue, $data);
    }


    /**
     * Проверка находиться ли указанный узел на текущей ветке.
     * @param array $data Данные полученные с выборки для построения пути.
     * @param int $id ID ветки.
     * @param int $idCurrent ID текущей ветки.
     * @return bool Если true, то узел находиться на текущей ветке.
     * @since 1.0
     * @version 1.0
     */
    public function isCurrentBranch($data, $id, $idCurrent)
    {
    return $this->newInstance()->isCurrentBranch($id, $idCurrent, $data);
    }
}
?>