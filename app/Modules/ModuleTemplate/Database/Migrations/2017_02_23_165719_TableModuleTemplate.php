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
class TableModuleTemplate extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('moduleTemplate', function(Blueprint $table)
		{
			$table->bigInteger('idModuleTemplate', true)->unsigned();
			$table->bigInteger('idModule')->unsigned()->index('idComponent');
			$table->string('labelTemplate', 150);
			$table->text('htmlTpl', 16777215)->nullable();
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
		Schema::drop('moduleTemplate');
	}

}
