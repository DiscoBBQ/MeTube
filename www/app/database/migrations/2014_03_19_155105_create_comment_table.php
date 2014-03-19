<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `comments` (
  		`user_id` int(11) DEFAULT NULL,
  		`media_id` int(11) DEFAULT NULL,
  		`comment` varchar(255) DEFAULT NULL,
  		`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
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
		DB::statement("DROP TABLE `comments`");
	}

}
