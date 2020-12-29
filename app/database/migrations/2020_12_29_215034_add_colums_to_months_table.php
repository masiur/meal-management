<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToMonthsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('months', function(Blueprint $table)
		{
            $table->enum('status', ['ACTIVE','RUNNING', 'COMPLETED', 'INACTIVE'])->default('RUNNING');
            $table->double('meal_rate');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('months', function(Blueprint $table)
		{
			//
		});
	}

}
