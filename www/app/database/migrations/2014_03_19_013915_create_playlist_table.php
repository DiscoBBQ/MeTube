<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `playlist` (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  		`user_id` int(11) DEFAULT NULL,
  		`title` varchar(255) DEFAULT NULL,
  		`description` varchar(255) DEFAULT NULL,
  		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP TABLE `playlist`");
	}

}
