<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('session', function(Blueprint $table)
		{
			$table->string('id')->primary();
			$table->integer('user_id')->unsigned()->nullable()->index('user_id');
			$table->string('ip_address', 45)->nullable()->index('ip_address');
			$table->text('user_agent', 65535)->nullable();
			$table->text('payload', 16777215);
			$table->integer('last_activity')->unsigned()->index('last_activity');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('session');
	}

}
