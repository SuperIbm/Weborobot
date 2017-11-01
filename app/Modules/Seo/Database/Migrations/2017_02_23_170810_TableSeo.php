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
class TableSeo extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('seo', function(Blueprint $table)
		{
			$table->bigInteger('idSeo', true)->unsigned();
			$table->date('dateStat')->unique('dateStat');
			$table->bigInteger('visits')->unsigned()->default(0);
			$table->bigInteger('shows')->unsigned()->default(0);
			$table->bigInteger('visitors')->unsigned()->default(0);
			$table->bigInteger('visitorsNew')->unsigned()->default(0);

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
		Schema::drop('seo');
	}

}
