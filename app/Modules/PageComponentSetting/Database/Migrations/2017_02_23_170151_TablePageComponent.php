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
class TablePageComponent extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('pageComponent', function(Blueprint $table)
		{
			$table->bigInteger('idPageComponent', true)->unsigned();
			$table->bigInteger('idComponent')->unsigned()->index('idComponentAction');
			$table->bigInteger('idPage')->unsigned()->index('idPage');
			$table->smallInteger('numberBlock')->unsigned()->default(0)->index('numberBlock');
			$table->boolean('weight')->default(0)->index('weight');
			$table->index(['idPage','idComponent','numberBlock','weight'], 'columnIndex_1');

            $table->timestamps();
            $table->softDeletes();
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
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
		Schema::drop('pageComponent');
	}

}
