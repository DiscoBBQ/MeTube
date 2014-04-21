<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToPlaylistItem extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE playlist_item ADD CONSTRAINT `playlist_item_media_fk` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
		DB::statement("ALTER TABLE playlist_item ADD CONSTRAINT `playlist_item_playlist_fk` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE playlist_item DROP FOREIGN KEY `playlist_item_media_fk`");
		DB::statement("ALTER TABLE playlist_item DROP FOREIGN KEY `playlist_item_playlist_fk`");
	}

}
