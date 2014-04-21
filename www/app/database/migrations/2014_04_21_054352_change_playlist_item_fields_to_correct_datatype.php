<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePlaylistItemFieldsToCorrectDatatype extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE playlist_item MODIFY media_id INT(11) unsigned");
		DB::statement("ALTER TABLE playlist_item MODIFY playlist_id INT(11) unsigned");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE playlist_item MODIFY media_id INT(11)");
		DB::statement("ALTER TABLE playlist_item MODIFY playlist_id INT(11)");
	}

}
