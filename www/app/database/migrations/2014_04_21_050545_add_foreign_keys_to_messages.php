<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE messages ADD CONSTRAINT `messages_from_user_fk` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
  	DB::statement("ALTER TABLE messages ADD CONSTRAINT `messages_parent_message_fk` FOREIGN KEY (`parent_message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE");
  	DB::statement("ALTER TABLE messages ADD CONSTRAINT `messages_to_user_fk` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE messages DROP FOREIGN KEY `messages_from_user_fk`");
		DB::statement("ALTER TABLE messages DROP FOREIGN KEY `messages_parent_message_fk`");
		DB::statement("ALTER TABLE messages DROP FOREIGN KEY `messages_to_user_fk`");
	}

}
