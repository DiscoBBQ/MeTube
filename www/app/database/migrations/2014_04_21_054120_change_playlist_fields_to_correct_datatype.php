<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePlaylistFieldsToCorrectDatatype extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE playlist MODIFY user_id INT(11) unsigned");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE playlist MODIFY user_id INT(11)");
	}

}
