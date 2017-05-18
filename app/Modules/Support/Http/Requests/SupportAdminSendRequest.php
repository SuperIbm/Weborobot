<?php
/**
 * Модуль Поддержки.
 * Этот модуль содержит все классы для работы поддержкой в административной системе.
 * @package App.Modules.Support
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Support\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс запрос для отправки email сообщения.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SupportAdminSendRequest extends FormRequest
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
        'theme' => 'required|between:1,255',
        'fio' => 'required|between:1,255',
        'email' => 'required|email',
        'message' => 'required|between:1,5000',
        'telephone' => 'between:18,18',
        'file' => 'file',
        'url' => 'url'
        ];
    }
}
