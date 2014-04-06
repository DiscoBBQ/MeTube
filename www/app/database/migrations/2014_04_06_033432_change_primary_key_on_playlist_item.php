<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePrimaryKeyOnPlaylistItem extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE playlist_item DROP PRIMARY KEY, ADD PRIMARY KEY (`item_order`,`media_id`,`playlist_id`)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE playlist_item DROP PRIMARY KEY, ADD PRIMARY KEY (`item_order`)");
	}

}
