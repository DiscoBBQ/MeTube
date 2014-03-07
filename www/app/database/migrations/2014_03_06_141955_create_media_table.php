<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `media` (
  		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  		`title` varchar(255) DEFAULT NULL,
 		`description` varchar(255) DEFAULT NULL,
 		`extension` varchar(32) DEFAULT NULL,
 		`authorid` int(11) DEFAULT NULL,
 		`created_on` date DEFAULT NULL,
 		`category` varchar(127) DEFAULT NULL,
 		`keywords` varchar(255) DEFAULT NULL,
 		PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP TABLE `media`;");
	}

}
