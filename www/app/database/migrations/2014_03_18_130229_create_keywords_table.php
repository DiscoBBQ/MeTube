<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `keywords` (
  		`mediaid` int(11) unsigned NOT NULL,
  		`keyword` varchar(255) NOT NULL,
  		PRIMARY KEY (`mediaid`, `keyword`)
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
		DB::statement("DROP TABLE `keywords`;");
	}

}
