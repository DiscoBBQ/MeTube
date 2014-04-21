<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToSubscriptions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE subscriptions ADD CONSTRAINT `subscriptions_subscribing_user_fk` FOREIGN KEY (`subscribing_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
  	DB::statement("ALTER TABLE subscriptions ADD CONSTRAINT `subscriptions_subscription_user_fk` FOREIGN KEY (`subscription_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE subscriptions DROP FOREIGN KEY `subscriptions_subscribing_user_fk`");
		DB::statement("ALTER TABLE subscriptions DROP FOREIGN KEY `subscriptions_subscription_user_fk`");
	}


}
