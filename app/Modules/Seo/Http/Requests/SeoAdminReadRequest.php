<?php
/**
 * Модуль Статистики сайта.
 * Этот модуль содержит все классы для работы со татистикой сайта.
 * @package App.Modules.Seo
 * @version 1.0
 * @since 1.0
 */
namespace App\Modules\Seo\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс запрос для чтения статистики сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SeoAdminReadRequest extends FormRequest
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
        'detalization' => 'required|in:По дням,По неделям,За весь срок,По месяцам',
        'date' => 'in:Сегодня,Вчера,Неделя,Месяц,Квартал,Год',
        'dateFrom' => 'date_format:Y-m-d',
        'dateTo' => 'date_format:Y-m-d'
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
        'detalization' => 'Детализация',
        'date' => 'Период',
        'dateFrom' => 'Начальная дата',
        'dateTo' => 'Конечная дата'
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
        'in' => 'Поле :attribute должно иметь один из следующих типов: :values.',
        'date_format' => 'Поле :attribute должно иметь формат :format'
        ];
    }
}
