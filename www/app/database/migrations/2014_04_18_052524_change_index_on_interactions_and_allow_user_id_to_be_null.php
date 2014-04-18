<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIndexOnInteractionsAndAllowUserIdToBeNull extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE interactions DROP PRIMARY KEY, MODIFY user_id INT DEFAULT NULL, ADD UNIQUE KEY `interaction_set` (`user_id`,`media_id`,`category`)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE interactions DROP INDEX `interaction_set`, MODIFY user_id INT NOT NULL DEFAULT '0', ADD PRIMARY KEY (`user_id`,`media_id`,`category`)");
	}

}
