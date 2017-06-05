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
class TableComponent extends Migration {

    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('component', function(Blueprint $table)
		{
			$table->bigInteger('idComponent', true)->unsigned();
			$table->bigInteger('idModule')->unsigned()->index('idModule');
			$table->string('controller', 150)->nullable();
			$table->string('nameComponent', 150);
			$table->string('labelComponent', 150);
			$table->string('pathToCss')->nullable();
			$table->string('pathToJs')->nullable();
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
		Schema::drop('component');
	}

}
