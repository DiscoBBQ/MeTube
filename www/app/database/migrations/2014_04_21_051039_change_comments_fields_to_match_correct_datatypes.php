<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCommentsFieldsToMatchCorrectDatatypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE comments MODIFY user_id INT(11) unsigned");
		DB::statement("ALTER TABLE comments MODIFY media_id INT(11) unsigned");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE comments MODIFY user_id INT(11)");
		DB::statement("ALTER TABLE comments MODIFY media_id INT(11)");
	}

}
