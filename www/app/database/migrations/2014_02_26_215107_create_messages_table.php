<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `messages` (
  		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  		`to_user_id` int(11) DEFAULT NULL,
  		`from_user_id` int(11) DEFAULT NULL,
  		`subject` varchar(255) DEFAULT NULL,
  		`message` text,
  		PRIMARY KEY (`id`)
		)
		ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP TABLE `messages`");
	}

}
