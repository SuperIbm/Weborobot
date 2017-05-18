<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Repositories;

use Config;
use Carbon\Carbon;
use Util;
use DB;
use Storage;

use App\Models\RepositaryEloquent;

/**
 * Класс репозитария обновления на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadEloquent extends Upload
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
    return $this->_get(['Upload', 'UploadItem'], $id);
    }


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
    public function read($filters = null, $sorts = null, $offset = null, $limit = null, $with = null)
    {
    return $this->_read(['Upload', 'UploadItem'], false, $filters, null, $sorts, $offset, $limit, $with);
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
    return $this->_read(['Upload', 'UploadItem'], true, $filters, null, null, null, null, $with);
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
    return $this->_create(['UploadItem'], $data);
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
    return $this->_update(['UploadItem'], $id, $data);
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
    return $this->_destroy(['UploadItem'], $id);
    }


    /**
     * Проверка обновления.
     * Во время проверки обновления запсывает все доступные обновления в таблицу.
     * @param array $rules Правила обновления, полученнные через \App\Modules\Upload\Repositories\UploadSource::getRules.
     * @return bool Вернет успешность выполнения операции по проверки обновления.
     * @since 1.0
     * @version 1.0
     */
    public function check($rules)
    {
    $modules = $this->_Module->read(null, true);

        if($modules)
        {
            for($i = 0; $i < count($rules); $i++)
            {
                if(isset($rules[$i]["success"]) && $rules[$i]["success"] == true)
                {
                    for($z = 0; $z < count($modules); $z++)
                    {
                        if(isset($rules[$i]["data"][$modules[$z]["nameModule"]]))
                        {
                        $nameModuleLower = Util::toLower($modules[$z]["nameModule"]);
                        $versions = [];
                        $moduleRules = $rules[$i]["data"][$modules[$z]["nameModule"]];

                            for($y = 0; $y < count($moduleRules); $y++)
                            {
                            $versionCurrent = explode(".", Config::get($nameModuleLower.'.version'));
                            $versionNext = explode(".", $moduleRules[$y]["version"]);

                                if($versionCurrent[0] == $versionNext[0] && version_compare($moduleRules[$y]["version"], Config::get($nameModuleLower.'.version'), '>') == true) $versions[] = $moduleRules[$y];
                            }

                            if(!empty($versions))
                            {
                                usort($versions,
                                    function($a, $b)
                                    {
                                        if($a["version"] == $b["version"]) return 0;
                                        return ($a["version"] < $b["version"]) ? 1 : -1;
                                    }
                                );

                                $upload = $this->read
                                (
                                    [
                                        [
                                        'property' => 'idModule',
                                        'value' => $modules[$z]["idModule"]
                                        ]
                                    ]
                                );

                                if(!$upload)
                                {
                                    $this->create
                                    (
                                        [
                                        'idModule' => $modules[$z]["idModule"],
                                        'nextDate' => Carbon::createFromFormat('Y-m-d', $versions[0]["date"]),
                                        'nextVersion' => $versions[0]["version"]
                                        ]
                                    );
                                }
                                else
                                {
                                    $this->update
                                    (
                                    $upload[0]['idUpload'],
                                        [
                                        'idModule' => $modules[$z]["idModule"],
                                        'nextDate' => Carbon::createFromFormat('Y-m-d', $versions[0]["date"]),
                                        'nextVersion' => $versions[0]["version"]
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
            }
        }

    return true;
    }


    /**
     * Установка обновления.
     * @param int $idUpload ID доступного обновления.
     * @param array $rules Правила обновления, полученнные через \App\Modules\Upload\Repositories\UploadSource::getRules.
     * @return bool Вернет успешность выполнения операции по установки обновления.
     * @since 1.0
     * @version 1.0
     */
    public function set($idUpload, $rules)
    {
        $uploads = $this->read
        (
            [
                [
                'property' => 'idUpload',
                'value' => $idUpload
                ]
            ],
            null,
            null,
            null,
            [
            'Module'
            ]
        );

        if($uploads)
        {
        $upload = $uploads[0];
        $upload['nameModule'] = $uploads[0]['module']['nameModule'];
        $findNextVersion = false;

            for($i = 0; $i < count($rules); $i++)
            {
                if(isset($rules[$i]["data"][$upload["nameModule"]]))
                {
                    for($z = 0; $z < count($rules[$i]["data"][$upload["nameModule"]]); $z++)
                    {
                        if($rules[$i]["data"][$upload["nameModule"]][$z]["version"] == $upload["nextVersion"])
                        {
                        $findNextVersion = true;
                        $rule = $rules[$i]["data"][$upload["nameModule"]][$z];

                            if(isset($rule["actions"]))
                            {
                                if
                                (
                                    isset($rule["actions"]["creates"]) ||
                                    isset($rule["actions"]["updates"]) ||
                                    isset($rule["actions"]["destroies"]) ||
                                    isset($rule["actions"]["replacies"])
                                )
                                {
                                    foreach($rule["actions"] as $k => $v)
                                    {
                                        foreach($rule["actions"][$k] as $k2 => $v2)
                                        {
                                            if($k2 == "components" || $k2 == "templates" || $k2 == "widgets" || $k2 == "sections")
                                            {
                                                for($r = 0; $r < count($rule["actions"][$k][$k2]); $r++)
                                                {
                                                    if($k == "destroies")
                                                    {
                                                        if($k2 == "components")
                                                        {
                                                            $components = $this->_Component->read
                                                            (
                                                                [
                                                                    [
                                                                    'property' => 'idModule',
                                                                    'value' => $upload["idModule"]
                                                                    ],
                                                                    [
                                                                    'property' => 'nameBundle',
                                                                    'value' => isset($rule["actions"][$k][$k2][$r]["nameBundle"]) ? $rule["actions"][$k][$k2][$r]["nameBundle"] : null
                                                                    ],
                                                                    [
                                                                    'property' => 'nameComponent',
                                                                    'value' => $rule["actions"][$k][$k2][$r]["nameComponent"]
                                                                    ]
                                                                ]
                                                            );

                                                            if($components)
                                                            {
                                                                for($y = 0; $y < count($components); $y++)
                                                                {
                                                                $this->_Component->destroy($components[$y]['idComponent']);
                                                                }
                                                            }
                                                        }
                                                        else if($k2 == "templates")
                                                        {
                                                            $moduleTemplates = $this->_ModuleTemplate->read
                                                            (
                                                                [
                                                                    [
                                                                    'property' => 'idModule',
                                                                    'value' => $upload["idModule"]
                                                                    ],
                                                                    [
                                                                    'property' => 'labelTemplate',
                                                                    'value' => $rule["actions"][$k][$k2][$r]["labelTemplate"]
                                                                    ]
                                                                ]
                                                            );

                                                            if($moduleTemplates)
                                                            {
                                                                for($y = 0; $y < count($moduleTemplates); $y++)
                                                                {
                                                                $this->_ModuleTemplate->destroy($moduleTemplates[$y]['idModuleTemplate']);
                                                                }
                                                            }
                                                        }
                                                        else if($k2 == "widgets")
                                                        {
                                                            $widgets = $this->_Widget->read
                                                            (
                                                                [
                                                                    [
                                                                    'property' => 'idModule',
                                                                    'value' => $upload["idModule"]
                                                                    ],
                                                                    [
                                                                    'property' => 'actionWidget',
                                                                    'value' => $rule["actions"][$k][$k2][$r]["actionWidget"]
                                                                    ]
                                                                ]
                                                            );

                                                            if($widgets)
                                                            {
                                                                for($y = 0; $y < count($widgets); $y++)
                                                                {
                                                                $this->_Widget->destroy($widgets[$y]['idWidget']);
                                                                }
                                                            }
                                                        }
                                                        else if($k2 == "sections")
                                                        {
                                                            $adminSections = $this->_AdminSectionTreeArray->read
                                                            (
                                                                [
                                                                    [
                                                                    'property' => 'idModule',
                                                                    'value' => $upload["idModule"]
                                                                    ],
                                                                    [
                                                                    'property' => 'labelSection',
                                                                    'value' => $rule["actions"][$k][$k2][$r]["labelSection"]
                                                                    ]
                                                                ]
                                                            );

                                                            if($adminSections)
                                                            {
                                                                for($y = 0; $y < count($adminSections); $y++)
                                                                {
                                                                $this->_AdminSectionTreeArray->destroy($adminSections[$y]['idAdminSection']);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                    $rule["actions"][$k][$k2][$r]['idModule'] = $upload["idModule"];
                                                    $rule["actions"][$k][$k2][$r]['status'] = "Активен";

                                                        if($k == "creates")
                                                        {
                                                            if($k2 == "components")
                                                            {
                                                                $components = $this->_Component->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'nameBundle',
                                                                        'value' => isset($rule["actions"][$k][$k2][$r]["nameBundle"]) ? $rule["actions"][$k][$k2][$r]["nameBundle"] : null
                                                                        ],
                                                                        [
                                                                        'property' => 'nameComponent',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["nameComponent"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if(!$components)
                                                                {
                                                                $this->_Component->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_Component->hasError() == true) $this->addError($this->_Component->getErrors());
                                                                }
                                                            }
                                                            else if($k2 == "templates")
                                                            {
                                                                $moduleTemplates = $this->_ModuleTemplate->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'labelTemplate',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["labelTemplate"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if(!$moduleTemplates)
                                                                {
                                                                $this->_ModuleTemplate->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_ModuleTemplate->hasError() == true) $this->addError($this->_ModuleTemplate->getErrors());
                                                                }

                                                            }
                                                            else if($k2 == "widgets")
                                                            {
                                                                $widgets = $this->_Widget->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'actionWidget',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["actionWidget"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if(!$widgets)
                                                                {
                                                                $this->_Widget->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_Widget->hasError() == true) $this->addError($this->_Widget->getErrors());
                                                                }
                                                            }
                                                            else if($k2 == "sections")
                                                            {
                                                                $adminSections = $this->_AdminSectionTreeArray->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'labelSection',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["labelSection"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if(!$adminSections)
                                                                {
                                                                $rule["actions"][$k][$k2][$r]['menuLeft'] = "Нет";
                                                                $rule["actions"][$k][$k2][$r] = $this->_setBundle($rule["actions"][$k][$k2][$r]);
                                                                $this->_AdminSectionTreeArray->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_AdminSectionTreeArray->hasError() == true) $this->addError($this->_AdminSectionTreeArray->getErrors());
                                                                }
                                                            }
                                                        }
                                                        else if($k == "updates" || $k == "replacies")
                                                        {
                                                            if($k2 == "components")
                                                            {
                                                                $components = $this->_Component->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'nameBundle',
                                                                        'value' => isset($rule["actions"][$k][$k2][$r]["nameBundle"]) ? $rule["actions"][$k][$k2][$r]["nameBundle"] : null
                                                                        ],
                                                                        [
                                                                        'property' => 'nameComponent',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["nameComponent"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if($components)
                                                                {
                                                                $this->_Component->update($components[0]['idComponent'], $rule["actions"][$k][$k2][$r]);

                                                                    if($this->_Component->hasError() == true) $this->addError($this->_Component->getErrors());
                                                                }
                                                                else if($k == "replacies")
                                                                {
                                                                $this->_Component->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_Component->hasError() == true) $this->addError($this->_Component->getErrors());

                                                                }
                                                            }
                                                            else if($k2 == "templates")
                                                            {
                                                                $moduleTemplates = $this->_ModuleTemplate->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'labelTemplate',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["labelTemplate"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if($moduleTemplates)
                                                                {
                                                                $this->_ModuleTemplate->update($moduleTemplates[0]['idModuleTemplate'], $rule["actions"][$k][$k2][$r]);

                                                                    if($this->_ModuleTemplate->hasError() == true) $this->addError($this->_ModuleTemplate->getErrors());
                                                                }
                                                                else if($k == "replacies")
                                                                {
                                                                $this->_ModuleTemplate->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_ModuleTemplate->hasError() == true) $this->addError($this->_ModuleTemplate->getErrors());
                                                                }

                                                            }
                                                            else if($k2 == "widgets")
                                                            {
                                                                $widgets = $this->_Widget->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'actionWidget',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["actionWidget"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if($widgets)
                                                                {
                                                                $this->_Widget->update($widgets[0]['idWidget'], $rule["actions"][$k][$k2][$r]);

                                                                    if($this->_Widget->hasError() == true) $this->addError($this->_Widget->getErrors());
                                                                }
                                                                else if($k == "replacies")
                                                                {
                                                                $this->_Widget->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_Widget->hasError() == true) $this->addError($this->_Widget->getErrors());
                                                                }
                                                            }
                                                            else if($k2 == "sections")
                                                            {
                                                                $adminSections = $this->_AdminSectionTreeArray->read
                                                                (
                                                                    [
                                                                        [
                                                                        'property' => 'idModule',
                                                                        'value' => $upload["idModule"]
                                                                        ],
                                                                        [
                                                                        'property' => 'labelSection',
                                                                        'value' => $rule["actions"][$k][$k2][$r]["labelSection"]
                                                                        ]
                                                                    ]
                                                                );

                                                                if($adminSections)
                                                                {
                                                                $rule["actions"][$k][$k2][$r] = $this->_setBundle($rule["actions"][$k][$k2][$r]);
                                                                $this->_AdminSectionTreeArray->update($adminSections[0]['idAdminSection'], $rule["actions"][$k][$k2][$r]);

                                                                    if($this->_AdminSectionTreeArray->hasError() == true) $this->addError($this->_AdminSectionTreeArray->getErrors());
                                                                }
                                                                else if($k == "replacies")
                                                                {
                                                                $rule["actions"][$k][$k2][$r]['menuLeft'] = 'Нет';
                                                                $rule["actions"][$k][$k2][$r] = $this->_setBundle($rule["actions"][$k][$k2][$r]);
                                                                $this->_AdminSectionTreeArray->create($rule["actions"][$k][$k2][$r]);

                                                                    if($this->_AdminSectionTreeArray->hasError() == true) $this->addError($this->_AdminSectionTreeArray->getErrors());
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            if(isset($rule["files"]))
                            {
                                if(isset($rule["files"]["destroies"]))
                                {
                                    for($y = 0; $y < count($rule["files"]["destroies"]); $y++)
                                    {
                                    $path = Storage::disk('root')->getDriver()->getAdapter()->applyPathPrefix($rule["files"]["destroies"][$y]);

                                        if(Storage::disk('root')->exists($rule["files"]["destroies"][$y]))
                                        {
                                            if(is_dir($path))
                                            {
                                            Storage::disk('root')->deleteDirectory($rule["files"]["destroies"][$y]);
                                            }
                                            else if(is_file($path))
                                            {
                                            Storage::disk('root')->delete($rule["files"]["destroies"][$y]);
                                            }
                                        }
                                    }
                                }
                                else if(isset($rule["files"]["uploads"]))
                                {
                                    for($y = 0; $y < count($rule["files"]["uploads"]); $y++)
                                    {
                                    $file = file_get_contents($rule["files"]["uploads"][$y]['file']);
                                    Storage::disk('root')->put($rule["files"]["uploads"][$y]['path'], $file);
                                    }
                                }
                            }

                            if(isset($rule["sqls"]))
                            {
                                for($y = 0; $y < count($rule["sqls"]); $y++)
                                {
                                DB::statement($rule["sqls"][$y]);
                                }
                            }

                            if(isset($rule["php"])) eval($rule["php"]);
                        }
                    }
                }
            }

            if($findNextVersion == true)
            {
                if($this->hasError() == false)
                {
                $this->destroy($idUpload);
                return true;
                }
                else return false;
            }
            else
            {
            $this->addError('noNextVersion', 'Ранее найденная следующая версия не была обнаружена не на одном удаленном ресурсе.');
            return false;
            }
        }
        else
        {
        $this->addError('noRecord', 'Запись '.$idUpload.' не была найдена.');
        return false;
        }
    }


    /**
     * Установка нужного пакета для раздела.
     * @param array $data Даные для сохранения в раздел административной системы.
     * @return array Вернет массив данных с нужным пакетом.
     * @since 1.0
     * @version 1.0
     */
    private function _setBundle($data)
    {
    $bundles = Config::get('adminsection.bundles');

        foreach($bundles as $k => $v)
        {
            if($data['bundle'] == $v)
            {
            $data['bundle'] = $k;
            break;
            }
        }

    return $data;
    }
}