<?php
/**
 * Модуль Шаблоны для страниц.
 * Этот модуль содержит все классы для работы с шаблонами для страниц.
 * @package App.Modules.PageTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageTemplate\Repositories;

use App\Models\Repositary;
use App\Modules\Page\Repositories\Page;
use App\Modules\PageComponent\Repositories\PageComponent;
use App\Modules\PageTemplate\Models\PageTemplateEloquent;


/**
 * Абстрактный класс построения репозитария.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class PageTemplate extends Repositary
{
/**
 * Репозитарий страниц.
 * @var \App\Modules\Page\Repositories\Page
 * @version 1.0
 * @since 1.0
 */
protected $_Page;

/**
 * Репозитарий компонентов страницы.
 * @var \App\Modules\PageComponent\Repositories\PageComponent
 * @version 1.0
 * @since 1.0
 */
protected $_PageComponent;

	/**
	 * Конструктор.
	 * @param \App\Modules\PageTemplate\Models\PageTemplateEloquent $Model Модель данного репозитария.
     * @param \App\Modules\Page\Repositories\Page $Page Репозитарий страниц.
     * @param \App\Modules\PageComponent\Repositories\PageComponent $PageComponent Репозитарий компонентов страницы.
	 * @since 1.0
	 * @version 1.0
	 */
	public function __construct(PageTemplateEloquent $Model, Page $Page, PageComponent $PageComponent)
	{
    parent::__construct($Model);
    $this->_Page = $Page;
    $this->_PageComponent = $PageComponent;
	}

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
     * @param array $with Массив связанных моделей.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function read($filters = null, $active = null, $sorts = null, $offset = null, $limit = null, $with = null);

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $with Массив связанных моделей.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    abstract public function count($filters = null, $active = null, $with = null);

    /**
     * Создание.
     * @param array $data Данные для добавления.
     * @param string $file Путь к файлу с архивом шаблона.
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract public function create(array $data, $file);

    /**
     * Обновление.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     * @param string $file Путь к файлу с архивом шаблона.
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract public function update($id, array $data, $file = null);

    /**
     * Удаление.
     * @param int|array $id Id записи для удаления.
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy($id);
}