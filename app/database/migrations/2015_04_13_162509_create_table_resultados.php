<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResultados extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resultados', function($table){
			$table->increments('id');
			$table->integer('solicitud_id')->unsigned();
			$table->foreign('solicitud_id')
						->references('id')->on('solicitudes')
						->onDelete('cascade');
			$table->string('estudio');
			$table->string('familia');
			$table->string('titulo');
			$table->string('nombre');
			$table->string('valor');
			$table->string('unidad');
			$table->string('resultado');
			$table->boolean('negrita');
			$table->timestamps();
		});

		Schema::create('observaciones', function($table){
			$table->increments('id');
			$table->integer('solicitud_id')->unsigned();
			$table->foreign('solicitud_id')
						->references('id')->on('solicitudes')
						->onDelete('cascade');
			$table->text('observacion');
			$table->text('observacion2');
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
		Schema::drop('resultados');
		Schema::drop('observaciones');
	}

}
