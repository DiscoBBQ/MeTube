<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToKeywords extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE keywords ADD CONSTRAINT `keywords_media_fk` FOREIGN KEY (`mediaid`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE keywords DROP FOREIGN KEY `keywords_media_fk`");
	}

}
