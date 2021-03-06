<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 * @package App.Modules.Image
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Image\Commands;

use Illuminate\Console\Command;
use Image;
use App;


/**
 * Класс комманда миграции изображений.
 * Позволяет мигрировать изображениям из одного драйвера хранения в другой.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageMigrateCommand extends Command
{
/**
 * Название консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $signature = 'weborobot:image-migrate {from : Current driver} {to : Another driver}';

/**
 * Описание консольной комманды.
 * @var string
 * @version 1.0
 * @since 1.0
 */
protected $description = 'Migrate the images from a driver to another driver.';

	/**
	 * Выполнение комманды.
	 * @return void
	 * @since 1.0
	 * @version 1.0
	 */
	public function fire()
	{
    $this->line('Migrating the images of site...');

	$images = Image::all();
	$count = count($images);
	$Bar = $this->output->createProgressBar($count);

		for($i = 0; $i < $count; $i++)
		{
		$pathSourceFrom = App::make('image.driver')->driver($this->argument('from'))->pathSource($images[$i]['idImage'], $images[$i]['format']);
		App::make('image.driver')->driver($this->argument('to'))->create($images[$i]['idImage'], $images[$i]['format'], $pathSourceFrom);
		$Bar->advance();
		}

    $Bar->finish();
    $this->info('\nThe migration of images has been successfully completed.');
	}
}
