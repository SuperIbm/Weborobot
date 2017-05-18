<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Repositories;

use App\Models\Repositary;

use App\Modules\Module\Repositories\Module;
use App\Modules\AdminSection\Repositories\AdminSectionTreeArray;
use App\Modules\Component\Repositories\Component;
use App\Modules\ModuleTemplate\Repositories\ModuleTemplate;
use App\Modules\Widget\Repositories\Widget;

/**
 * Абстрактный класс построения репозитария для обновления.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Upload extends Repositary
{
/**
 * Репозитарий модуля.
 * @var \App\Modules\Module\Repositories\Module
 * @version 1.0
 * @since 1.0
 */
protected $_Module;

/**
 * Репозитарий разделов административной системы.
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
 * Репозитарий шаблонов компонента.
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
     * Конструктор.
     * @param object $Model Модель данного репозитария.
     * @param \App\Modules\Module\Repositories\Module Репозитарий модуля.
     * @param \App\Modules\AdminSection\Repositories\AdminSectionTreeArray Репозитарий разделов административной системы в виде древовидной структуры.
     * @param \App\Modules\Component\Repositories\Component Репозитарий компонентов.
     * @param \App\Modules\ModuleTemplate\Repositories\ModuleTemplate Репозитарий шаблонов компонента.
     * @param \App\Modules\Widget\Repositories\Widget Репозитарий виджетов.
     * @since 1.0
     * @version 1.0
     */
    public function __construct($Model, Module $Module, AdminSectionTreeArray $AdminSectionTreeArray, Component $Component, ModuleTemplate $ModuleTemplate, Widget $Widget)
    {
    parent::__construct($Model);
    $this->_Module = $Module;
    $this->_AdminSectionTreeArray = $AdminSectionTreeArray;
    $this->_Component = $Component;
    $this->_ModuleTemplate = $ModuleTemplate;
    $this->_Widget = $Widget;
    }

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
     * @param array $with Массив связанных моделей.
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function read($filters = null, $sorts = null, $offset = null, $limit = null, $with = null);

    /**
     * Подсчет общего количества записей.
     * @param array $filters Фильтрация данных.
     * @param array $with Массив связанных моделей.
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    abstract public function count($filters = null, $with = null);

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
     * Проверка обновления.
     * Во время проверки обновления запсывает все доступные обновления в таблицу.
     * @param array $rules Правила обновления, полученнные через \App\Modules\Upload\Repositories\UploadSource::getRules.
     * @return bool Вернет успешность выполнения операции по проверки обновления.
     * @since 1.0
     * @version 1.0
     */
    abstract public function check($rules);


    /**
     * Установка обновления.
     * @param int $idUpload ID доступного обновления.
     * @param array $rules Правила обновления, полученнные через \App\Modules\Upload\Repositories\UploadSource::getRules.
     * @return bool Вернет успешность выполнения операции по установки обновления.
     * @since 1.0
     * @version 1.0
     */
    abstract public function set($idUpload, $rules);
}