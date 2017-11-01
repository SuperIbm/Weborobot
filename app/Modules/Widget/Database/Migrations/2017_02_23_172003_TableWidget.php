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
class TableWidget extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('widget', function(Blueprint $table)
		{
			$table->bigInteger('idWidget', true)->unsigned();
			$table->integer('idModule')->unsigned()->index('idModule');
			$table->string('actionWidget', 150);
			$table->string('labelWidget', 150);
			$table->string('icon')->nullable();
			$table->string('pathToCss')->nullable();
			$table->string('pathToJs');
			$table->boolean('def')->default(0)->index('default');
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
		Schema::drop('widget');
	}

}
