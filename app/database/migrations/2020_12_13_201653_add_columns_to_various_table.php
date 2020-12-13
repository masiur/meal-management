<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToVariousTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// add email and sms count
		Schema::table('members', function(Blueprint $table)
		{
			$table->integer('email_count')->unsigned();
			$table->integer('sms_count')->unsigned();
			$table->string('additional_info')->nullable();
		});
		// add notes to meal_counts
		Schema::table('meal_counts', function(Blueprint $table)
		{
			$table->string('notes')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('members', function(Blueprint $table)
		{
			$table->dropColumn(['email_count', 'sms_count', 'additional_info']);
		});

		Schema::table('meal_counts', function(Blueprint $table)
		{
			$table->dropColumn(['notes']);
		});
	}

}
