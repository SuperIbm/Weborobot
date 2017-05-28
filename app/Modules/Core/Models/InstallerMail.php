<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use Exception;
use Config;
use App\Models\Decorator;
use Mail;

/**
 * Запуск установки конфигурации для почтовых отправлений.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerMail extends Decorator
{
    /**
     * Метод получения индекса.
     * Этот индекс используется в массиве данных для сохранения тех данных, которые были созданы этим декоратором.
     * @return string Название индекса.
     * @since 1.0
     * @version 1.0
     */
    public function getIndex()
    {
    return "redis";
    }


    /**
     * Запуск установщика.
     * @param array $params Параметры декоратора.
     * @param \App\Models\Decorator $ParentDecorator Родительский декоратор.
     * @return bool Должен вернуть true если действие выполнено успешно.
     * @since 1.0
     * @version 1.0
     */
    protected function _action($params, Decorator $ParentDecorator = null)
    {
    $connected = false;

        $data =
        [
        'MAIL_DRIVER' => '',
        'MAIL_HOST' => '',
        'MAIL_PORT' => '',
        'MAIL_USERNAME' => '',
        'MAIL_PASSWORD' => '',
        'MAIL_ENCRYPTION' => '',
        'MAIL_FROM_ADDRESS' => '',
        'MAIL_FROM_NAME' => '',
        'MAIL_TO_ADDRESS' => ''
        ];

    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();

        if($Root->getCommand()->confirm('Would you like setting mail system? [Y|N]', false))
        {
            while(!$connected)
            {
            /**
             * @var $Root \App\Modules\Core\Models\Installer
             */
            $data['MAIL_DRIVER'] = $Root->getCommand()->choice('Select mail driver', ['smtp', 'mail', 'sendmail', 'mailgun', 'mandrill', 'ses', 'sparkpost', 'log'], 1);
            $data['MAIL_ENCRYPTION'] = $Root->getCommand()->ask('Enter a encryption', 'tls');
            $data['MAIL_FROM_ADDRESS'] = $this->_borrow('Enter a from address');
            $data['MAIL_FROM_NAME'] = $this->_borrow('Enter a from name');
            $data['MAIL_TO_ADDRESS'] = $this->_borrow('Enter an email by default');

                if($Root->getCommand()->confirm('Would you like setting an authentication for your mail server? [Y|N]', false))
                {
                $data['MAIL_HOST'] = $this->_borrow('Enter a host for your mail server');
                $data['MAIL_PORT'] = $this->_borrow('Enter a port for your mail server');
                $data['MAIL_USERNAME'] = $this->_borrow('Enter an user of name for your mail server');
                $data['MAIL_PASSWORD'] = $this->_borrow('Enter a password for your mail server');
                }

            Config::set('mail.driver', $data['MAIL_DRIVER']);
            Config::set('mail.encryption', $data['MAIL_ENCRYPTION']);
            Config::set('mail.from.address', $data['MAIL_FROM_ADDRESS']);
            Config::set('mail.from.name', $data['MAIL_FROM_NAME']);
            Config::set('mail.to', $data['MAIL_TO_ADDRESS']);

            Config::set('mail.host', $data['MAIL_HOST']);
            Config::set('mail.port', $data['MAIL_PORT']);
            Config::set('mail.username', $data['MAIL_USERNAME']);
            Config::set('mail.password', $data['MAIL_USERNAME']);

                try
                {
                    Mail::raw("It's testing...",
                        function($Message) use ($data)
                        {
                        $Message->from($data["MAIL_FROM_ADDRESS"]);
                        $Message->sender($data["MAIL_FROM_NAME"]);
                        $Message->to($data["MAIL_TO_ADDRESS"]);
                        $Message->subject("Hello. It's just testing...");
                        }
                    );

                $connected = true;
                }
                catch(Exception $Exeption)
                {
                $Root->getCommand()->error("Please ensure your mail server credentials are valid.");
                }
            }
        }

    $this->_setData($data);
    return true;
    }


    /**
     * Запрос данных, но без обязательного указания.
     * @param string $ask Вопрос.
     * @return string Вернет результат запроса.
     * @since 1.0
     * @version 1.0
     */
    private function _borrow($ask)
    {
    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();
    $answer = $Root->getCommand()->ask($ask, 'NULL');

        if($answer == 'NULL') $answer = null;

    return $answer;
    }
}
