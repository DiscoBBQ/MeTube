<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `subscriptions` (
  		`subscribing_user_id` int(11) DEFAULT NULL,
  		`subscription_user_id` int(11) DEFAULT NULL,
  		PRIMARY KEY (`subscribing_user_id`, `subscription_user_id`)
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
		DB::statement("DROP TABLE `subscriptions`");
	}

}
