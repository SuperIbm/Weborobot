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
class TableLog extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('log', function(Blueprint $table)
		{
			$table->bigInteger('idLog', true)->unsigned();
			$table->string('channel', 50)->nullable();
			$table->text('message')->nullable();
			$table->string('level', 50)->nullable()->index('level');
			$table->string('level_name', 100)->nullable();
			$table->text('context')->nullable();
			$table->text('formatted')->nullable();
			$table->dateTime('dateAdd')->nullable()->index('dateAdd');
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
		Schema::drop('log');
	}
}
