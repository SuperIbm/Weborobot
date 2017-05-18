<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Config;

use App\Modules\ImageTmp\Http\Controllers\ImageTmpController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Modules\Image\Commands\ImageMigrateCommand::class,
        \App\Modules\Document\Commands\DocumentMigrateCommand::class,
        \App\Modules\Sitemap\Commands\SitemapCreateCommand::class,
        \App\Modules\Upload\Commands\UploadCheckCommand::class,
        \App\Modules\Upload\Commands\UploadListCommand::class,
        \App\Modules\Upload\Commands\UploadSetCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $Schedule
     * @return void
     */
    protected function schedule(Schedule $Schedule)
    {
    $Schedule->exec('rm -r '.storage_path('app/tmp/*'))->daily();
    $Schedule->exec('rm -r '.storage_path('smarty/compile/*'))->hourly();
    $Schedule->exec('rm -r '.storage_path('smarty/cache/*'))->hourly();
    $Schedule->exec('mysqlcheck --user='.Config::get('database.connections.mysql.username').' --password='.Config::get('database.connections.mysql.password').' --optimize '.Config::get('database.connections.mysql.database'))->weekly();

        $Schedule->call
        (
            function()
            {
            $ImageTmpController = new ImageTmpController();
            $ImageTmpController->destroyOld();
            }
        );
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
