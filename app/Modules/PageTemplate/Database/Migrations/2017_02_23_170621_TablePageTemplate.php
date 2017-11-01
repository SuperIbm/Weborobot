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
class TablePageTemplate extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('pageTemplate', function(Blueprint $table)
		{
			$table->bigInteger('idPageTemplate', true)->unsigned();
			$table->string('labelTemplate', 150);
			$table->string('nameTemplate', 150);
			$table->smallInteger('countBlocks')->unsigned()->default(0);
			$table->bigInteger('idImage')->unsigned()->nullable();
			$table->boolean('status')->default(0)->index('status');
			$table->index(['idPageTemplate','idImage','status'], 'columnIndex_1');

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
		Schema::drop('pageTemplate');
	}

}
