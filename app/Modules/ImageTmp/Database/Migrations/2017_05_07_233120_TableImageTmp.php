<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


/**
 * Класс миграции.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class TableImageTmp extends Migration {

    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('imageTmp', function(Blueprint $table)
		{
			$table->bigInteger('idImageTmp', true)->unsigned();
			$table->bigInteger('idImageSource')->unsigned()->unique('idImageSource');
			$table->bigInteger('idImageThumbnail')->unsigned()->unique('idImageThumbnail');
			$table->dateTime('dateAdd')->index('datAdd');
			$table->string('tags')->nullable()->index('tag');
		});
	}


    /**
     * Запуск отката миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function down()
	{
		Schema::drop('imageTmp');
	}

}
