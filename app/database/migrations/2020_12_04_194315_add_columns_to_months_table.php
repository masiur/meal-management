<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMonthsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('months', function(Blueprint $table)
		{

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
					->references('id')->on('users')
					->onDelete('cascade')
					->onUpdate('cascade');

			$table->text('notes')->nullable();
			$table->date('start_time')->nullable();
			$table->date('closing_time')->nullable();
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
			$table->dropColumn(['user_id', 'start_time', 'closing_time', 'notes']);
		});
	}

}
