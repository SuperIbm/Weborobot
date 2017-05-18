<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 * @package App.Modules.Document
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Document\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс проверки запроса для создания документа.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentCreateRequest extends FormRequest
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
		'file' => 'required|document',
		'id' => 'required|integer|digits_between:1,20',
		'format' => 'required|in:jpg,png,gif,jpeg,swf,flw'
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
        'file' => 'Файл документа',
        'id' => 'ID записи',
        'format' => 'Формат файла'
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
        'document' => 'Поле :attribute должно содержать файл.',
        'integer' => 'Поле :attribute должно содержать число.',
        'digits_between' => 'Поле :attribute должно находится в диапозоне от :min до :max символов.',
        'in' => 'Поле :attribute должно иметь один из следующих типов: :values.'
        ];
    }
}