<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToMealCountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('meal_counts', function(Blueprint $table)
		{
			$table->string('status')->default('ACTIVE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('meal_counts', function(Blueprint $table)
		{
			$table->dropColumn(['status']);
		});
	}

}
