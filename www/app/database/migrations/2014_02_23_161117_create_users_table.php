<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `users` (
  		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  		`username` varchar(50) DEFAULT NULL,
  		`email` varchar(255) DEFAULT NULL,
  		`crypted_passwoed` varchar(255) DEFAULT NULL,
  		`salt` varchar(255) DEFAULT NULL,
  		`created_at` timestamp NULL DEFAULT NULL,
  		`updated_at` datetime DEFAULT NULL,
  		PRIMARY KEY (`id`)
		)
		ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("DROP TABLE `users`;");
	}

}
