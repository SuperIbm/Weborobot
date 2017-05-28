<?php
/**
 * Модуль Sitemap.
 * Этот модуль содержит все классы для работы с sitemap.
 * @package App.Modules.Sitemap
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Sitemap\Commands;

use Illuminate\Console\Command;
use Storage;

use App\Modules\Sitemap\Models\Sitemap;


/**
 * Класс комманда для создания sitemap.xml на сайте.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SitemapCreateCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:sitemap-create {path? : Path to starting} {allow? : Path(s) to allow (divided by comma)} {disallow? : Path(s) to disallow (divided by comma)}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Create a new sitemap.xml for the site.';

	/**
	 * Выполнение комманды.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function fire()
	{
    $Sitemap = new Sitemap();

    $this->line('Scaning the pages of site...');
    $Bar = $this->output->createProgressBar();

        $Sitemap->addEvent('beforeScan',
            function() use ($Bar)
            {
            $Bar->advance();
            return true;
            }
        );

    $pages = $Sitemap->scan($this->argument('path'), explode(',', $this->argument('allow')), explode(',', $this->argument('disallow')));

    $Bar->finish();
    $this->line("");
    $this->info('Finished scanning the pages of site.');
    $this->line('Writing the results into sitemap.xml...');

        if($pages)
        {
            $xml = view('sitemap::sitemap',
                [
                    'SITEMAP' =>
                    [
                    'pages' => $pages
                    ]
                ]
            );

        Storage::disk('root')->put("sitemap.xml", $xml);
        }

    $this->info('Sitemap.xml has been successfully created.');
	}
}
