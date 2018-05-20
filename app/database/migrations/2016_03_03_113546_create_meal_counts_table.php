<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMealCountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meal_counts', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('member_id')->unsigned();
			$table->foreign('member_id')
					->references('id')->on('members')
					->onDelete('cascade')
					->onUpdate('cascade');

			$table->integer('month_id')->unsigned();
			$table->foreign('month_id')
					->references('id')->on('months')
					->onDelete('cascade')
					->onUpdate('cascade');
			
			$table->float('count');
			$table->float('balance');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('meal_counts');
	}

}
