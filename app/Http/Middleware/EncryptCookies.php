<?php
/**
 * Основные посредники.
 * @package App.Http.Middleware
 * @version 1.0
 * @since 1.0
 */
namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

/**
 * Класс посредник для шифрования куки.
 * @version 1.0
 * @since 1.0
 */
class EncryptCookies extends BaseEncrypter
{
    /**
     * Название куки которые не следует шифровать.
     * @var array
     */
    protected $except = [
        //
    ];
}
