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
class TablePage extends Migration {

    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('page', function(Blueprint $table)
		{
			$table->bigInteger('idPage', true)->unsigned();
			$table->bigInteger('idPageTemplate')->unsigned()->nullable()->index('idTemplatesForPages');
			$table->bigInteger('idPageReferen')->unsigned()->index('idPageRefer');
			$table->string('namePage');
			$table->string('nameLink')->nullable()->index('nameLink');
			$table->text('description', 65535)->nullable();
			$table->text('keywords', 65535)->nullable();
			$table->string('title')->nullable();
			$table->text('html', 16777215)->nullable();
			$table->bigInteger('weight')->default(0)->index('weight');
			$table->boolean('showInMenu')->default(0);
			$table->string('modeAccess', 15);
			$table->string('redirect')->nullable();
			$table->dateTime('dateEdit');
			$table->boolean('status')->default(0)->index('status');
			$table->index(['idPage','status'], 'columnIndex_1');
			$table->index(['idPageReferen','nameLink','status'], 'columnIndex_2');

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
		Schema::drop('page');
	}

}
