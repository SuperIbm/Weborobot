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
class TableUserRole extends Migration {

    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('userRole', function(Blueprint $table)
		{
			$table->bigInteger('idUserRole', true)->unsigned();
			$table->string('nameRole', 100);
			$table->boolean('status')->default(0)->index('status');

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
		Schema::drop('userRole');
	}

}
