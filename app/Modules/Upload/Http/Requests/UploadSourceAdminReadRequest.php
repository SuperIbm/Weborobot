<?php
/**
 * Модуль Обновления.
 * Этот модуль содержит все классы для работы с обновлениями.
 * @package App.Modules.Upload
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Upload\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс запрос для чтения источников обновления.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UploadSourceAdminReadRequest extends FormRequest
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
        'sort' => 'json',
        'filter' => 'json',
        'start' => 'integer|digits_between:0,20',
        'limit' => 'integer|digits_between:0,20',
        'id' => 'integer|digits_between:0,20'
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
        'sort' => 'Сортировка',
        'filter' => 'Фильр',
        'start' => 'Начальная позиция записи',
        'limit' => 'Количество записей',
        'id' => 'ID записи'
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
        'integer' => 'Поле :attribute должно содержать число.',
        'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
        'json' => 'Поле :attribute должно содержать корректный JSON строку.'
        ];
    }
}
