<?php
/**
 * Модуль Поддержки.
 * Этот модуль содержит все классы для работы поддержкой в административной системе.
 * @package App.Modules.Support
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Support\Emails;

use Mail;
use Config;
use Util;

/**
 * Класс отправки сообщения администратору сайта.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class EmailAdmin
{
    /**
     * Отправка сообщения.
     * @param string $theme Тема сообщения.
     * @param string $fio ФИО пользователя.
     * @param string $email E-mail пользователя.
     * @param string $message Сообщене для отправки.
     * @param string $telephone Телефон сообщения.
     * @param string $url Ссылка для отправки.
     * @param string $file Путь к файлу для отправки его в письме.
     * @param string $fileName Название файла.
     * @return bool Вернет статус успешности отправки сообщения.
     * @since 1.0
     * @version 1.0
     */
    public function send($theme, $fio, $email, $message, $telephone = null, $url = null, $file = null, $fileName = null)
    {
        Mail::send('support::mailAdmin',
            [
            'theme' => $theme,
            'fio' => $fio,
            'email' => $email,
            'msg' => Util::parserRnToBr($message),
            'telephone' => $telephone,
            'url' => $url
            ],
            function($Message) use ($theme, $file, $fileName)
            {
            $Message->from(Config::get('mail.from.address'), Config::get('mail.from.name'));
            $Message->sender(Config::get('mail.from.address'), Config::get('mail.from.name'));

                if($file)
                {
                $Message->subject($theme);

                    if($fileName)
                    {
                        $Message->attach($file,
                            [
                            'as' => $fileName
                            ]
                        );
                    }
                }
            }
        );

    return true;
    }
}