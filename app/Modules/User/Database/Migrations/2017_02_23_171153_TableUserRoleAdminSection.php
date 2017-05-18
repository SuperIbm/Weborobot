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
class TableUserRoleAdminSection extends Migration {

    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('userRoleAdminSection', function(Blueprint $table)
		{
			$table->bigInteger('idUserRoleAdminSection', true)->unsigned();
			$table->bigInteger('idUserRole')->unsigned()->index('idUserRole');
			$table->bigInteger('idAdminSection')->unsigned()->index('idAdminkaSection');
			$table->boolean('isRead');
			$table->boolean('isUpdate');
			$table->boolean('isCreate');
			$table->boolean('isDestroy');
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
		Schema::drop('userRoleAdminSection');
	}

}
