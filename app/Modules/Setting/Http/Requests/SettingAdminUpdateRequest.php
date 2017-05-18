<?php
/**
 * Модуль Настройки сайта.
 * Этот модуль содержит все классы для работы с настройками сайта.
 * @package App.Modules.Setting
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Setting\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс запрос для изменения настроек сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SettingAdminUpdateRequest extends FormRequest
{
    /**
     * Определяем нужно ли пользователю быть авторизованным чтобы выполнить это действие.
     * @return bool Статус проверки.
     * @since 1.0
     * @version 1.0
     */
    public function authorize()
    {
    return true;
    }

    /**
     * Возвращает правила проверки.
     * @return array Массив правил проверки.
     * @since 1.0
     * @version 1.0
     */
    public function rules()
    {
        return
        [
        'label' => 'required|between:1,255',
        'value' => 'between:0,255'
        ];
    }

    /**
     * Возвращает атрибуты.
     * @return array Массив атрибутов.
     * @version 1.0
     * @since 1.0
     */
    public function attributes()
    {
        return
        [
        'label' => 'Название настройки',
        'value' => 'Значение настройки'
        ];
    }

    /**
     * Возвращает сообщения об ошибках.
     * @return array Массив сообщений об ошибках.
     * @version 1.0
     * @since 1.0
     */
    public function messages()
    {
        return
        [
        'required' => 'Поле :attribute должно быть определено.',
        'between' => 'Поле :attribute должно быть длиней :min символов, но короче :max символов.',
        ];
    }
}
