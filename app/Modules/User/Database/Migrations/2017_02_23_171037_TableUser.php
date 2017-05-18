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
class TableUser extends Migration {

    /**
     * Запуск миграции.
     * @return void
     * @version 1.0
     * @since 1.0
     */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->bigInteger('idUser', true)->unsigned();
			$table->bigInteger('idImageSmall')->unsigned()->nullable()->index('idImage');
			$table->bigInteger('idImageMiddle')->unsigned()->nullable();
			$table->string('login')->unique('login');
			$table->string('password')->index('password');
			$table->string('remember_token', 100)->nullable()->index('remember_token');
			$table->string('firstname', 150)->nullable();
			$table->string('secondname', 150)->nullable();
			$table->string('lastname', 150)->nullable();
			$table->string('email')->nullable();
			$table->string('telephone', 30)->nullable();
			$table->string('sex', 20)->nullable();
			$table->date('birthday')->nullable();
			$table->string('icq', 15)->nullable();
			$table->string('skype', 150)->nullable();
			$table->string('zip', 20)->nullable();
			$table->string('country', 200)->nullable();
			$table->string('city', 200)->nullable();
			$table->string('street', 200)->nullable();
			$table->string('passportSeriaAndNumber', 11)->nullable();
			$table->string('passportWhoMade', 250)->nullable();
			$table->date('passportWhenMade')->nullable();
			$table->string('passportCodeSection', 7)->nullable();
			$table->string('passportAdress', 250)->nullable();
			$table->string('organForma', 10)->nullable();
			$table->string('organName', 250)->nullable();
			$table->text('organAbout', 65535)->nullable();
			$table->string('site', 150)->nullable();
			$table->dateTime('dateAdd');
			$table->dateTime('dateLastEnter')->nullable();
			$table->string('ip', 15)->nullable();
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
		Schema::drop('user');
	}

}
