<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistItemTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("CREATE TABLE `playlist_item` (
  		`item_order` int(11) unsigned NOT NULL AUTO_INCREMENT,
  		`media_id` int(11) DEFAULT NULL,
  		`playlist_id` int(11) DEFAULT NULL,
  		PRIMARY KEY (`item_order`)
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
		DB::statement("DROP TABLE `playlist_item`");
	}

}
