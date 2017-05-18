<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */
namespace App\Models;

use Illuminate\Foundation\Http\FormRequest as FormRequestNative;
use Illuminate\Http\JsonResponse;

/**
 * Класс формы проверки запроса.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FormRequest extends FormRequestNative
{
    /**
     * Формирования ответа.
     * Формируем собственный формат JSON для ответа, чтобы у ExtJs была возможность его прочесть.
     * @param array $errors Массив ошибок.
     * @return \Symfony\Component\HttpFoundation\Response
     * @version 1.0
     * @since 1.0
     */
    public function response(array $errors)
    {
        if($errors && $this->expectsJson())
        {
        $message = null;
        $errortype = null;

            foreach($errors as $key => $value)
            {
                for($i = 0; $i < count($value); $i++)
                {
                $message = $value[$i];
                $errortype = $key;
                break;
                }
            }

            return new JsonResponse
            (
                [
                'success' => false,
                'errortype' => $errortype,
                'errormsg' => $message
                ],
                200
            );
        }
        else return parent::response($errors);
    }
}