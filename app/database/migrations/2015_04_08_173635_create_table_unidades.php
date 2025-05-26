<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUnidades extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('unidades', function($table){
			$table->increments('id');
			$table->integer('estudio_id')->unsigned();
			$table->foreign('estudio_id')
						->references('id')->on('estudios')
						->onDelete('cascade');
			$table->integer('familia_id')->unsigned();
			$table->foreign('familia_id')
						->references('id')->on('familias')
						->onDelete('cascade');
			$table->string('titulo');
			$table->string('nombre');
			$table->string('valor');
			$table->string('unidad');
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
		Schema::drop('unidades');
	}

}
