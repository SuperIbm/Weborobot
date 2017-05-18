<?php
/**
 * Модуль "Модулей".
 * Этот модуль содержит все классы для работы с модулями.
 * @package App.Modules.Module
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Module\Repositories;

use Artisan;
use Storage;
use Zip;
use Config;
use App\Models\RepositaryEloquent;
use Util;

/**
 * Класс репозитария модулей на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleEloquent extends Module
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
    return $this->_get(['Module', 'ModuleItem'], $id, $active);
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
    return $this->_read(['Module', 'ModuleItem'], false, $filters, $active, $sorts, $offset, $limit, $with);
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
    return $this->_read(['Module', 'ModuleItem'], true, $filters, $active, null, null, null, $with);
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
    return $this->_create(['ModuleItem'], $data);
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
    return $this->_update(['ModuleItem'], $id, $data);
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
    return $this->_destroy(['ModuleItem'], $id);
    }


    /**
     * Метод перехватчик при распоковке архива модуля.
     * @param array $p_event
     * @param array $p_header
     * @return bool
     * @since 1.0
     * @version 1.0
     */
	static public function preExtractCallback($p_event, &$p_header)
    {
        if(file_exists($p_header['filename']) && is_file($p_header['filename']))
        {
        unlink($p_header['filename']);
        }

    return 1;
    }


    /**
     * Установка модуля.
     * @param string $nameDir Папка модуля.
     * @param string $file Путь к файлу с архивом модуля.
     * @return bool Вернет true, если установка прошла успешно.
     * @since 1.0
     * @version 1.0
     */
	public function installModule($nameDir, $file)
    {
        Artisan::call('module:make',
            [
            'name' => [$nameDir]
            ]
        );

    $nameDirLower = Util::toLower($nameDir);
    Storage::disk('modules')->makeDirectory($nameDir.'/');
    $pathToDir = Storage::disk('modules')->getDriver()->getAdapter()->applyPathPrefix($nameDir.'/');

    Zip::setFile($file);
    Zip::extract(PCLZIP_OPT_PATH, $pathToDir, PCLZIP_CB_PRE_EXTRACT, 'App\Modules\Module\Repositories\ModuleEloquent::preExtractCallback');

        if(Zip::errorCode() == 0)
        {
        Config::set($nameDirLower, require $pathToDir.'Config/config.php');

            if($this->_isCorrectVersion(Config::get('app.version'), Config::get($nameDirLower.'.version')))
            {
                $idModule = $this->create
                (
                    [
                    'nameModule' => $nameDir,
                    'labelModule' => Config::get($nameDirLower.'.label'),
                    'status' => 'Активен'
                    ]
                );

                if($idModule)
                {
                    if(Config::get($nameDirLower.'.section'))
                    {
                    $section = Config::get($nameDirLower.'.section');

                        if($section['bundle'] == "Контент") $section['bundle'] =  "CONTENT";
                        else if($section['bundle'] == "Сервисы") $section['bundle'] = "SERVICES";
                        else if($section['bundle'] == "Продажи") $section['bundle'] = "SALES";
                        else if($section['bundle'] == "Управление") $section['bundle'] = "MANEGER";
                        else if($section['bundle'] == "Продвижение") $section['bundle'] = "SEO";
                        else if($section['bundle'] == "Система") $section['bundle'] = "SYSTEM";

                    $section['idModule'] = $idModule;
                    $section['labelSection'] = Config::get($nameDirLower.'.label');
                    $section['status'] = 'Активен';

                    $bundles = Config::get('adminsection.bundles');

                        foreach($bundles as $k => $v)
                        {
                            if($section['bundle'] == $v)
                            {
                            $section['bundle'] = $k;
                            break;
                            }
                        }

                    $idAdminSection = $this->_AdminSectionTreeArray->create($section);

                        $this->_UserRoleAdminSection->create
                        (
                            [
                            'idUserRole' => 1,
                            'idAdminSection' => $idAdminSection,
                            'isRead' => 1,
                            'isUpdate' => 1,
                            'isCreate' => 1,
                            'isDestroy' => 1
                            ]
                        );

                        $this->_UserRoleAdminSection->create
                        (
                            [
                            'idUserRole' => 2,
                            'idAdminSection' => $idAdminSection,
                            'isRead' => 1,
                            'isUpdate' => 1,
                            'isCreate' => 1,
                            'isDestroy' => 0
                            ]
                        );
                    }

                    if(Config::get($nameDirLower.'.components')) $this->_installComponent($idModule, Config::get($nameDirLower.'.components'));

                    if(Config::get($nameDirLower.'.templates'))
                    {
                    $templates = Config::get($nameDirLower.'.templates');

                        for($i = 0; $i < count($templates); $i++)
                        {
                            $this->_ModuleTemplate->create
                            (
                                [
                                'idModule' => $idModule,
                                'labelTemplate' => $templates[$i]['labelTemplate'],
                                'htmlTpl' => $templates[$i]['htmlTpl'],
                                'status' => 'Активен'
                                ]
                            );
                        }
                    }

                    if(Config::get($nameDirLower.'.widgets')) $this->_installWidget($idModule, Config::get($nameDirLower.'.widgets'));

                    Artisan::call('module:migrate',
                        [
                        'module' => $nameDir
                        ]
                    );

                    Artisan::call('module:seed',
                        [
                        'module' => $nameDir
                        ]
                    );

                return true;
                }
                else return false;
            }
            else
            {
            Storage::disk('modules')->deleteDirectory($nameDir.'/');
            $this->addError('isNotCorrectVersion', 'Данная версия модуля не подходит под текущую версию системы.');
            return false;
            }
        }
        else
        {
        Storage::disk('modules')->deleteDirectory($nameDir.'/');
        $this->addError('isNoCorrectArchive', 'Некорректный архив модуля.');
        return false;
        }
    }

    /**
     * Установка компонента по ID модуля и списку самих компонентов.
     * @param int $idModule ID модуля.
     * @param array $components Массив компонентов для установки.
     * @return bool Вернет true, если установка прошла успешно.
     * @since 1.0
     * @version 1.0
     */
    protected function _installComponent($idModule, $components)
    {
        for($i = 0; $i < count($components); $i++)
        {
            $this->_Component->create
            (
                [
                'idModule' => $idModule,
                'nameBundle' => isset($components[$i]['nameBundle']) ? $components[$i]['nameBundle'] : null,
                'nameComponent' => $components[$i]['nameComponent'],
                'labelComponent' => $components[$i]['labelComponent'],
                'pathToCss' => isset($components[$i]['pathToCss']) ? $components[$i]['pathToCss'] : null,
                'pathToJs' => isset($components[$i]['pathToJs']) ? $components[$i]['pathToJs'] : null,
                'status' => 'Активен'
                ]
            );
        }

    return true;
    }


    /**
     * Установка компонента.
     * @param string $nameDir Папка модуля.
     * @param string $file Путь к файлу с архивом модуля.
     * @return bool Вернет true, если установка прошла успешно.
     * @since 1.0
     * @version 1.0
     */
    public function installComponent($nameDir, $file)
    {
    $pathToDir = Storage::disk('modules')->getDriver()->getAdapter()->applyPathPrefix($nameDir.'/');
    $nameDirLower = Util::toLower($nameDir);

    Zip::setFile($file);
    Zip::extract(PCLZIP_OPT_PATH, $pathToDir);

        if(Zip::errorCode() == 0)
        {
        Config::set($nameDirLower, require $pathToDir.'Config/config.php');

            if($this->_isCorrectVersion(Config::get('app.version'), Config::get($nameDirLower.'.version')))
            {
                $module = $this->read
                (
                    [
                        [
                        'property' => 'nameModule',
                        'value' => Config::get($nameDirLower.'.name')
                        ]
                    ]
                );

                if($module)
                {
                    if(Config::get($nameDirLower.'.components')) $this->_installComponent($module[0]['idModule'], Config::get($nameDirLower.'.components'));

                return true;
                }
                else
                {
                $this->addError('noModule', 'Модуль '.Config::get($nameDirLower.'.label').' в системе не обнаружен.');
                return false;
                }
            }
            else
            {
            $this->addError('isNotCorrectVersion', 'Данная версия модуля не подходит под текущую версию системы.');
            return false;
            }
        }
        else
        {
        $this->addError('isNoCorrectArchive', 'Некорректный архив модуля.');
        return false;
        }
    }


    /**
     * Установка виджета по ID модуля и списку самих виджетов.
     * @param int $idModule ID модуля.
     * @param array $widgets Массив виджетов для установки.
     * @return bool Вернет true, если установка прошла успешно.
     * @since 1.0
     * @version 1.0
     */
    protected function _installWidget($idModule, $widgets)
    {
        for($i = 0; $i < count($widgets); $i++)
        {
            $this->_Widget->create
            (
                [
                'idModule' => $idModule,
                'actionWidget' => $widgets[$i]['actionWidget'],
                'labelWidget' => $widgets[$i]['labelWidget'],
                'icon' => $widgets[$i]['icon'],
                'pathToCss' => isset($widgets[$i]['pathToCss']) ? $widgets[$i]['pathToCss'] : null,
                'pathToJs' => $widgets[$i]['pathToJs'],
                'def' => $widgets[$i]['def'],
                'status' => 'Активен'
                ]
            );
        }

    return true;
    }


    /**
     * Установка виджета.
     * @param string $nameDir Папка модуля.
     * @param string $file Путь к файлу с архивом модуля.
     * @return bool Вернет true, если установка прошла успешно.
     * @since 1.0
     * @version 1.0
     */
    public function installWidget($nameDir, $file)
    {
    $pathToDir = Storage::disk('modules')->getDriver()->getAdapter()->applyPathPrefix($nameDir.'/');
    $nameDirLower = Util::toLower($nameDir);

    Zip::setFile($file);
    Zip::extract(PCLZIP_OPT_PATH, $pathToDir);

        if(Zip::errorCode() == 0)
        {
        Config::set($nameDir, require $pathToDir.'Config/config.php');

            if($this->_isCorrectVersion(Config::get('app.version'), Config::get($nameDirLower.'.version')))
            {
                $module = $this->read
                (
                    [
                        [
                        'property' => 'nameModule',
                        'value' => Config::get($nameDirLower.'.name')
                        ]
                    ]
                );

                if($module)
                {
                    if(Config::get($nameDirLower.'.widgets')) $this->_installWidget($module[0]['idModule'], Config::get($nameDirLower.'.widgets'));

                return true;
                }
                else
                {
                $this->addError('noModule', 'Модуль '.Config::get($nameDirLower.'.label').' в системе не обнаружен.');
                return false;
                }
            }
            else
            {
            $this->addError('isNotCorrectVersion', 'Данная версия модуля не подходит под текущую версию системы.');
            return false;
            }
        }
        else
        {
        $this->addError('isNoCorrectArchive', 'Некорректный архив модуля.');
        return false;
        }
    }


    /**
     * Проверка соотвествия версий.
     * @param string $versionFirst Первая версия.
     * @param string $versionSecond Вторая версия.
     * @return bool Вернет true, если версии соотвествуют.
     * @since 1.0
     * @version 1.0
     */
    protected function _isCorrectVersion($versionFirst, $versionSecond)
    {
    $versionCurrent = explode(".", $versionFirst);
    $versionModule = explode(".", $versionSecond);

    return $versionCurrent[0] == $versionModule[0];
    }
}