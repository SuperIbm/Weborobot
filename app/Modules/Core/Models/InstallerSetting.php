<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Models;

use App\Models\Decorator;

/**
 * Запуск установки дополнительных настроек системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerSetting extends Decorator
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
    return "setting";
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
    /**
     * @var $Root \App\Modules\Core\Models\Installer
     */
    $Root = $this->getRootDecorator();

        $data =
        [
        'APP_SITE_RECONSTRUCTION' => false,
        'APP_NAME' => 'Weborobot',
        'APP_ENV' => 'local',
        'APP_DEBUG' => true,
        'APP_URL' => 'http://localhost',
        'APP_TIMEZONE' => 'Europe/Moscow',
        'APP_LOCALE' => 'ru',

        'APP_LOG' => 'single',
        'APP_LOG_DRIVER' => 'file',
        'APP_LOG_LEVEL' => 'debug',

        'APP_CSS' => 'css/main.css',

        'CACHE_DRIVER' => 'memcache',
        'QUEUE_DRIVER' => 'database',
        'SESSION_DRIVER' => 'database',

        'IMAGE' => 'database',
        'IMAGE_DRIVER' => 'local',

        'DOCUMENT' => 'database',
        'DOCUMENT_DRIVER' => 'local',

        'SEO_DRIVER' => 'database'
        ];

        if($Root->getCommand()->confirm('Would you like entering additional settings? [Y|N]', false))
        {
        $data['APP_SITE_RECONSTRUCTION'] = $Root->getCommand()->confirm('Is your site in reconstraction? [Y|N]', $data['APP_SITE_RECONSTRUCTION']);
        $data['APP_NAME'] = $Root->getCommand()->ask('Enter your site name', $data['APP_NAME']);
        $data['APP_ENV'] = $Root->getCommand()->ask('Enter your environment', $data['APP_ENV']);
        $data['APP_DEBUG'] = $Root->getCommand()->ask('Enable error display?', $data['APP_DEBUG']);
        $data['APP_URL'] = $Root->getCommand()->ask('Enter an url of your site', $data['APP_URL']);
        $data['APP_TIMEZONE'] = $Root->getCommand()->ask('Enter a timezone for your site', $data['APP_TIMEZONE']);
        $data['APP_LOCALE'] = $Root->getCommand()->ask('Enter your locale', $data['APP_LOCALE']);

        $data['APP_LOG_DRIVER'] = $Root->getCommand()->choice('Where do you want to prefer storing your logs?', ['database', 'mongodb', 'file'], 0);

        $data['APP_CSS'] = $Root->getCommand()->ask('Enter a path to your main css file', $data['APP_CSS']);

        $data['CACHE_DRIVER'] = $Root->getCommand()->choice('Where do you want to prefer storing your cache?', ['apc', 'array', 'database', 'file', 'memcached', 'redis', 'memcache'], 6);
        $data['QUEUE_DRIVER'] = $Root->getCommand()->choice('Would you like using a queue driver?', ['sync', 'database', 'beanstalkd', 'sqs', 'redis'], 1);
        $data['SESSION_DRIVER'] = $Root->getCommand()->choice('Where do you want to prefer storing your session?', ['file', 'cookie', 'database', 'apc', 'memcached', 'redis', 'array', 'memcache'], 2);

        $data['IMAGE'] = $Root->getCommand()->ask('Where do you want to prefer storing your records for your images?', $data['IMAGE']);
        $data['IMAGE_DRIVER'] = $Root->getCommand()->ask('Where do you want to prefer storing your images?', $data['IMAGE_DRIVER']);

        $data['DOCUMENT'] = $Root->getCommand()->ask('Where do you want to prefer storing your records for your documents?', $data['DOCUMENT']);
        $data['DOCUMENT_DRIVER'] = $Root->getCommand()->ask('Where do you want to prefer storing your documents?', $data['DOCUMENT_DRIVER']);

        $data['SEO_DRIVER'] = $Root->getCommand()->ask('Where do you want to prefer storing your data for SEO?', $data['SEO_DRIVER']);
        }

    $this->_setData($data);
    return true;
    }
}
