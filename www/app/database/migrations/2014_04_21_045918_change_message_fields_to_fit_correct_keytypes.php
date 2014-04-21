<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMessageFieldsToFitCorrectKeytypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE messages MODIFY to_user_id INT(11) unsigned");
		DB::statement("ALTER TABLE messages MODIFY from_user_id INT(11) unsigned");
		DB::statement("ALTER TABLE messages MODIFY parent_message_id INT(11) unsigned");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE messages MODIFY to_user_id INT(11)");
		DB::statement("ALTER TABLE messages MODIFY from_user_id INT(11)");
		DB::statement("ALTER TABLE messages MODIFY parent_message_id INT(11)");
	}

}
