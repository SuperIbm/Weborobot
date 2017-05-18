<?php
/**
 * Основные посредники.
 * @package App.Http.Middleware
 * @version 1.0
 * @since 1.0
 */
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

/**
 * Проверка записи CSRF.
 * @version 1.0
 * @since 1.0
 */
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * URL которые не нужно проверять записи CSRF с форм.
     * @var array
     */
    protected $except = [
        //
    ];
}
