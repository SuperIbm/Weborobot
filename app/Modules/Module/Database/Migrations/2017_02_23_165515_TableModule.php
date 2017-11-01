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
class TableModule extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('module', function(Blueprint $table)
		{
			$table->bigInteger('idModule', true)->unsigned();
			$table->string('nameModule', 150)->unique('nameModule');
			$table->string('labelModule', 150);
			$table->boolean('status')->default(0)->index('status');
			$table->index(['idModule','status'], 'columnIndex_1');

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
		Schema::drop('module');
	}

}
