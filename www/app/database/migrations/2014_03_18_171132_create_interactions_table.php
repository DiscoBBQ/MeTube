<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInteractionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `interactions` (
  		`user_id` int(11) DEFAULT NULL,
  		`media_id` int(11) DEFAULT NULL,
  		`category` varchar(32) DEFAULT NULL,
  		PRIMARY KEY (`user_id`, `media_id`, `category`)
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
		DB::statement("DROP TABLE `interactions`");
	}

}
