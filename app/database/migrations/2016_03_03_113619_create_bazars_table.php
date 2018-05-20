<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBazarsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bazars', function(Blueprint $table)
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
			$table->float('amount');
			$table->string('date');
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
		Schema::drop('bazars');
	}

}
