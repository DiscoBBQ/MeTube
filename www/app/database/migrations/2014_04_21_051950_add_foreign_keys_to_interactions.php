<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToInteractions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE interactions ADD CONSTRAINT `interactions_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
  	DB::statement("ALTER TABLE interactions ADD CONSTRAINT `interactions_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE interactions DROP FOREIGN KEY `interactions_user_fk`");
		DB::statement("ALTER TABLE interactions DROP FOREIGN KEY `interactions_media_fk`");
	}

}
