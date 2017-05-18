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
class TableAlias extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('alias', function(Blueprint $table)
		{
			$table->bigInteger('idAlias', true)->unsigned();
			$table->string('pattern', 250)->default('');
			$table->bigInteger('idPage')->unsigned()->nullable()->index('idPage');
			$table->boolean('status')->default(0)->index('status');
			$table->index(['status','idPage'], 'columnIndex_1');
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
		Schema::drop('alias');
	}

}
