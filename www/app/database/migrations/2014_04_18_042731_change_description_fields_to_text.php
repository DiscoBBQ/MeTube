<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDescriptionFieldsToText extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement("ALTER TABLE comments MODIFY comment TEXT;");
		DB::statement("ALTER TABLE media MODIFY description TEXT;");
		DB::statement("ALTER TABLE playlist MODIFY description TEXT;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE comments MODIFY comment VARCHAR(255);");
		DB::statement("ALTER TABLE media MODIFY description VARCHAR(255);");
		DB::statement("ALTER TABLE playlist MODIFY description VARCHAR(255);");
	}

}
