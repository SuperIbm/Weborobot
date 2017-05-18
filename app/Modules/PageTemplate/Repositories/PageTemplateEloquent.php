<?php
/**
 * Модуль Шаблоны для страниц.
 * Этот модуль содержит все классы для работы с шаблонами для страниц.
 * @package App.Modules.PageTemplateTemplate
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageTemplate\Repositories;

use Cache;
use Storage;
use Zip;
use App\Models\RepositaryEloquent;

/**
 * Класс репозитария шаблона страницы на основе Eloquent.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageTemplateEloquent extends PageTemplate
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
    return $this->_get(['PageTemplate', 'PageTemplateItem'], $id, $active);
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
    return $this->_read(['PageTemplate', 'PageTemplateItem'], false, $filters, $active, $sorts, $offset, $limit, $with);
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
    return $this->_read(['PageTemplate', 'PageTemplateItem'], true, $filters, $active, null, null, null, $with);
    }

    /**
     * Проверка шаблона на корректность.
     * @param array $listFiles Список файлов в архиве шаблона.
     * @return bool Вернет true, если шаблон прошел проверку.
     * @since 1.0
     * @version 1.0
     */
    protected function _checkTemplate($listFiles)
    {
    $findDirTpl = false;
    $findFileTemplate = false;

        for($i = 0; $i < count($listFiles); $i++)
        {
            if($listFiles[$i]["stored_filename"] == "tpl/") $findDirTpl = true;
            if($listFiles[$i]["stored_filename"] == "tpl/template.tpl") $findFileTemplate = true;
        }

        if($findDirTpl == true && $findFileTemplate == true) return true;
        else return false;
    }

	/**
	 * Создание.
	 * @param array $data Данные для добавления.
     * @param string $file Путь к файлу с архивом шаблона.
	 * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	public function create(array $data, $file)
	{
	$Model = $this->newInstance();
	$Model = $Model->create($data);

        if(!$Model->hasError())
        {
        Storage::disk('templates')->makeDirectory($data['nameTemplate'].'/');
        $pathToDir = Storage::disk('templates')->getDriver()->getAdapter()->applyPathPrefix($data['nameTemplate'].'/');

        Zip::setFile($file);
        $listFiles = Zip::extract(PCLZIP_OPT_PATH, $pathToDir);

            if(Zip::errorCode() == 0)
            {
            $result = $this->_checkTemplate($listFiles);

                if($result)
                {
                Cache::tags(['PageTemplateItem'])->flush();
                return $Model->idPageTemplate;
                }
                else
                {
                $this->destroy($Model->idPageTemplate);
                Storage::disk('templates')->deleteDirectory($data['nameTemplate'].'/');
                $this->addError('isNoCorrectStructurArchive', 'Некорректная структура шаблона.');

                return false;
                }
            }
            else
            {
            $this->destroy($Model->idPageTemplate);
            Storage::disk('templates')->deleteDirectory($data['nameTemplate'].'/');
            $this->addError('isNoCorrectArchive', 'Некорректный архив шаблона.');
            return false;
            }
        }
        else
        {
        $this->addError($Model->getErrors());
        return false;
        }
	}

	/**
	 * Обновление.
	 * @param int $id Id записи для обновления.
	 * @param array $data Данные для обновления.
     * @param string $file Путь к файлу с архивом шаблона.
	 * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
	 * @since 1.0
	 * @version 1.0
	 */
	public function update($id, array $data, $file = null)
	{
	$Model = $this->newInstance()->find($id);

		if($Model)
		{
        $record = $this->get($data['idPageTemplate']);
		$status = $Model->update($data);

			if($Model->hasError() == true && $status == false)
			{
			$this->addError($Model->getErrors());
			return false;
			}
			else
            {
            $result = true;

                if($data['nameTemplate'])
                {
                $pathToDirOld = Storage::disk('templates')->getDriver()->getAdapter()->applyPathPrefix($record['nameTemplate'].'/');
                $pathToDir = Storage::disk('templates')->getDriver()->getAdapter()->applyPathPrefix($data['nameTemplate'].'/');

                    if($pathToDirOld != $pathToDir) rename($pathToDirOld, $pathToDir);
                }
                else $pathToDir = Storage::disk('templates')->getDriver()->getAdapter()->applyPathPrefix($record['nameTemplate'].'/');

                if($file)
                {
                Zip::setFile($file);
                $listFiles = Zip::extract(PCLZIP_OPT_PATH, $pathToDir);

                    if(Zip::errorCode() == 0)
                    {
                    $result = $this->_checkTemplate($listFiles);

                        if(!$result)
                        {
                        $this->addError('isNoCorrectStructurArchive', 'Некорректная структура шаблона.');
                        return false;
                        }
                    }
                    else
                    {
                    $this->addError('isNoCorrectArchive', 'Некорректный архив шаблона.');
                    return false;
                    }
                }

                if($result == true)
                {
                    if($data['countBlocks'] &&  $record['countBlocks'] > $data['countBlocks'])
                    {
                        $pages = $this->_PageComponent->read
                        (
                            [
                                [
                                'property' => 'idPageTemplate',
                                'value' => $data['idPageTemplate']
                                ]
                            ]
                        );

                        if($pages)
                        {
                            for($i = 0; $i < count($pages); $i++)
                            {
                                $pagesComponents = $this->_PageComponent->read
                                (
                                    [
                                        [
                                        'property' => 'idPageTemplate',
                                        'value' => $pages[$i]['idPageTemplate']
                                        ]
                                    ]
                                );

                                if($pagesComponents)
                                {
                                    for($z = $data['countBlocks'] + 1; $z < count($pagesComponents); $z++)
                                    {
                                    $this->_PageComponent->destroy($pagesComponents[$z]['idPageTemplateComponent']);
                                    }
                                }
                            }
                        }
                    }

                Cache::tags(['PageTemplateItem'])->flush();
                return $id;
                }
                else return false;
            }
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
	public function destroy($id)
	{
	$Model = $this->newInstance();
    $record = $this->get($id);
	$status = $Model->destroy($id);

		if(!$status) $this->addError($Model->getErrors());
		else
        {
        Storage::disk('templates')->deleteDirectory($record['nameTemplate'].'/');
        Cache::tags(['PageTemplateItem'])->flush();
        }

	return $status;
	}
}