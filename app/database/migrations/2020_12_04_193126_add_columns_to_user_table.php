<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{

			$table->string('flat_short_name')->unique();
			$table->string('flat_full_name')->nullable();
			$table->string('flat_mobile_number')->nullable();
			$table->string('flat_address');
			$table->string('flat_logo')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn(['flat_short_name', 'flat_full_name', 'flat_mobile_number', 'flat_address', 'flat_logo']);
		});
	}

}
