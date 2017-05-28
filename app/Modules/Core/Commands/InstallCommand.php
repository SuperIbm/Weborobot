<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 * @package App.Modules.Core
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Core\Commands;

use Installer;
use Illuminate\Console\Command;

use App\Modules\Core\Models\InstallerProtect;
use App\Modules\Core\Models\InstallerDatabase;
use App\Modules\Core\Models\InstallerMongoDb;
use App\Modules\Core\Models\InstallerRedis;
use App\Modules\Core\Models\InstallerMail;
use App\Modules\Core\Models\InstallerAppKey;
use App\Modules\Core\Models\InstallerMigrator;
use App\Modules\Core\Models\InstallerSeeder;
use App\Modules\Core\Models\InstallerSetting;
use App\Modules\Core\Models\InstallerSave;
use App\Modules\Core\Models\InstallerFlag;


/**
 * Класс комманда для установки системы.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:install';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Install the system.';

    /**
	 * Выполнение комманды.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function fire()
	{
        Installer::setCommand($this)
        ->addDecorators
        (
            [
            new InstallerProtect(),
            new InstallerDatabase(),
            new InstallerMongoDb(),
            new InstallerRedis(),
            new InstallerMail(),
            new InstallerSetting(),
            new InstallerMigrator(),
            new InstallerSeeder(),
            new InstallerAppKey(),
            new InstallerFlag(),
            new InstallerSave()
            ]
        )
        ->run();
	}
}
