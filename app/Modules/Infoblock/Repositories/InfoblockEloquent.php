<?php
/**
 * Модуль Инфоблоков.
 * Этот модуль содержит все классы для работы с инфоблоками.
 * @package App.Modules.Infoblock
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Infoblock\Repositories;

use App\Models\RepositaryEloquent;

/**
 * Класс репозитария инфоблоков на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InfoblockEloquent extends Infoblock
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
    return $this->_get(['Infoblock', 'InfoblockItem'], $id, $active);
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
    return $this->_read(['Infoblock', 'InfoblockItem'], false, $filters, $active, $sorts, $offset, $limit);
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
    return $this->_read(['Infoblock', 'InfoblockItem'], true, $filters, $active);
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
    return $this->_create(['InfoblockItem'], $data);
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
    return $this->_update(['InfoblockItem'], $id, $data);
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
    return $this->_destroy(['InfoblockItem'], $id);
	}
}