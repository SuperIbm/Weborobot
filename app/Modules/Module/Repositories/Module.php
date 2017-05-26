<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Repositories;

use App\Modules\AdminSection\Repositories\AdminSectionTreeArray;
use App\Modules\Component\Repositories\Component;
use App\Modules\ModuleTemplate\Repositories\ModuleTemplate;
use App\Models\Repositary;
use App\Modules\Widget\Repositories\Widget;
use App\Modules\User\Repositories\UserRoleAdminSection;


/**
 * Абстрактный класс построения репозитария.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Module extends Repositary
{
/**
 * Репозитарий разделов административной системы в виде древовидной структуры.
 * @var \App\Modules\AdminSection\Repositories\AdminSectionTreeArray
 * @version 1.0
 * @since 1.0
 */
protected $_AdminSectionTreeArray;

/**
 * Репозитарий компонентов.
 * @var \App\Modules\Component\Repositories\Component
 * @version 1.0
 * @since 1.0
 */
protected $_Component;

/**
 * Репозитарий шаблонов модулей.
 * @var \App\Modules\ModuleTemplate\Repositories\ModuleTemplate
 * @version 1.0
 * @since 1.0
 */
protected $_ModuleTemplate;

/**
 * Репозитарий виджетов.
 * @var \App\Modules\Widget\Repositories\Widget
 * @version 1.0
 * @since 1.0
 */
protected $_Widget;

/**
 * Репозитарий для выбранных разделов роли.
 * @var \App\Modules\User\Repositories\UserRoleAdminSection
 * @version 1.0
 * @since 1.0
 */
protected $_UserRoleAdminSection;

	/**
	 * Конструктор.
	 * @param object $Model Модель данного репозитария.
     * @param \App\Modules\AdminSection\Repositories\AdminSectionTreeArray $AdminSectionTreeArray Репозитарий разделов административной системы в виде древовидной структуры.
     * @param \App\Modules\Component\Repositories\Component $Component Репозитарий компонентов.
     * @param \App\Modules\ModuleTemplate\Repositories\ModuleTemplate Репозитарий шаблонов модулей.
     * @param \App\Modules\User\Repositories\UserRoleAdminSection $UserRoleAdminSection Репозитарий для выбранных разделов роли.
	 * @since 1.0
	 * @version 1.0
	 */
	public function __construct($Model, AdminSectionTreeArray $AdminSectionTreeArray, Component $Component, ModuleTemplate $ModuleTemplate, Widget $Widget, UserRoleAdminSection $UserRoleAdminSection)
	{
	parent::__construct($Model);
    $this->_AdminSectionTreeArray = $AdminSectionTreeArray;
    $this->_Component = $Component;
    $this->_ModuleTemplate = $ModuleTemplate;
    $this->_Widget = $Widget;
    $this->_UserRoleAdminSection = $UserRoleAdminSection;
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
     * Установка модуля.
     * @param string $nameDir Папка модуля.
     * @param string $file Путь к файлу с архивом модуля.
     * @return bool Вернет true, если установка прошла успешно.
     * @since 1.0
     * @version 1.0
     */
    abstract public function install($nameDir, $file);
}