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
class TableAdminSection extends Migration
{
    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
        Schema::create('adminSection', function(Blueprint $table)
        {
            $table->increments('idAdminSection');
            $table->bigInteger('idModule')->unsigned()->unique('idModule');
            $table->string('labelSection', 100)->unique('labelSection');
            $table->string('bundle', 150);
            $table->string('iconSmall')->nullable();
            $table->string('iconBig')->nullable();
            $table->boolean('menuLeft')->default(0);
            $table->string('pathToCss');
            $table->string('pathToJs');
            $table->boolean('weight')->nullable()->index('weight');
            $table->boolean('status')->default(0)->index('status');
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
		Schema::drop('adminSection');
	}
}
