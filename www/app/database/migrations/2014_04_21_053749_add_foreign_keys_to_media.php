<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToMedia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE media ADD CONSTRAINT `media_user_fk` FOREIGN KEY (`authorid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE media DROP FOREIGN KEY `media_user_fk`");
	}

}
