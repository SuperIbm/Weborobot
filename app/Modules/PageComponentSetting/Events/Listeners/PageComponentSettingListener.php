<?php
/**
 * Модуль Настройки компонента страницы.
 * Этот модуль содержит все классы для работы настройками компонента на странице.
 * @package App.Modules.PageComponentSetting
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\PageComponentSetting\Events\Listeners;

use App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent;

/**
 * Класс обработчик событий для модели настрое компонента на странице.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PageComponentSettingListener
{
	/**
	 * Обработчик события при добавлении записи.
	 * @param \App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent $PageComponentSetting Модель для таблицы настроек компонента на странице.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function creating(PageComponentSettingEloquent $PageComponentSetting)
	{
		$result = $PageComponentSetting->newQuery()
        ->where("idPageComponent", $PageComponentSetting->idPageComponent)
        ->where("nameSetting", $PageComponentSetting->nameSetting)
        ->first();

		if($result)
		{
        $PageComponentSetting->addError('validate', 'Вы не можете добавить такую настройку, т.к. она уже есть в базе данных!', 'nameSetting');
        return false;
		}

    return true;
	}


	/**
	 * Обработчик события при обновлении записи.
	 * @param \App\Modules\PageComponentSetting\Models\PageComponentSettingEloquent $PageComponentSetting Модель для таблицы настроек компонента на странице.
	 * @return bool Вернет успешность выполнения операции.
	 * @version 1.0
	 * @since 1.0
	 */
	public function updating(PageComponentSettingEloquent $PageComponentSetting)
	{
		$result = $PageComponentSetting->newQuery()
        ->where("idPageComponentSetting", "!=", $PageComponentSetting->idPageComponentSetting)
        ->where("idPageComponent", $PageComponentSetting->idPageComponent)
        ->where("nameSetting", $PageComponentSetting->nameSetting)
        ->first();

		if($result)
		{
        $PageComponentSetting->addError('validate', 'Вы не можете добавить такую настройку, т.к. она уже есть в базе данных!', 'nameSetting');
        return false;
		}

    return true;
	}
}