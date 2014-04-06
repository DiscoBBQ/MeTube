<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdToComments extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE comments ADD COLUMN `id` int(11) unsigned NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY(id) ");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE comments DROP COLUMN id, DROP PRIMARY KEY ");
	}

}
