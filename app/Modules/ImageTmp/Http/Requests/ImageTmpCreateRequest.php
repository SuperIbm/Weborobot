<?php
/**
 * Модуль Временных изображений.
 * Этот модуль содержит все классы для работы с временными изображениями.
 * @package App.Modules.ImageTmp
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\ImageTmp\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс проверки запроса для создания временного изображения.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageTmpCreateRequest extends FormRequest
{
	/**
	 * Определяем нужно ли пользователю быть авторизованным для выполнения этого действия.
	 * @return bool Статус нужности проверки.
	 * @version 1.0
	 * @since 1.0
	 */
	public function authorize()
	{
	return true;
	}

	/**
	 * Получить правила валидации для запроса.
	 * @return array Правила валидирования.
	 * @version 1.0
	 * @since 1.0
	 */
	public function rules()
	{
		return
		[
		'file' => 'required|image',
        'width' => 'integer|digits_between:0,5',
        'height' => 'integer|digits_between:0,5',
        'tags' => 'json',
        'filters' => 'json'
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
        'file' => 'Файл изображения',
        'width' => 'Ширина превью изображения',
        'height' => 'Высота превью изображения',
        'filters' => 'Фильтры превью изображения',
        'tags' => 'Тэги'
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
        'image' => 'Поле :attribute должно содержать изображение.',
        'integer' => 'Поле :attribute должно содержать число.',
        'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
        'json' => 'Поле :attribute должно содержать корректный JSON строку.'
        ];
    }
}