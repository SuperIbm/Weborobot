<?php
/**
 * Модуль Файловая система.
 * Этот модуль содержит все классы для работы с файловой системой.
 * @package App.Modules.Filesystem
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Filesystem\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс запрос для создания файла.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FilesystemFileAdminCreateRequest extends FormRequest
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
        'nameFull' => 'between:0,255',
        'file' => 'required|file',
        'path' => 'required|path'
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
        'nameFull' => 'Название файла',
        'file' => 'Файл на закачку',
        'path' => 'Путь к папке для закачки'
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
        'between' => 'Поле :attribute должно быть длиней :min символов, но короче :max символов.',
        'required' => 'Поле :attribute должно быть определено.',
        'file' => 'Поле :attribute должно содержать файл.',
        'path' => 'Поле :attribute должно содержать ссылку на папку для закачивания.'
        ];
    }
}
