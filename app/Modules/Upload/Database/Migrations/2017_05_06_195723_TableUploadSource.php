<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class TableUploadSource extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('uploadSource', function(Blueprint $table)
		{
			$table->bigInteger('idUploadSource', true)->unsigned();
			$table->string('login')->nullable()->index('login');
			$table->string('password')->nullable();
			$table->string('url', 250);
			$table->boolean('status')->default(0)->index('status');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('uploadSource');
	}

}
