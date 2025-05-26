<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSolicitudes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitudes', function($table){
			$table->increments('id');
			$table->string('folios');
			$table->date('fecha_solicitud');
			$table->string('folio');
			$table->string('clinica');
			$table->string('mvz');
			$table->string('telefono');
			$table->string('email');
			$table->DateTime('toma_muestra');
			$table->integer('familia_id')->unsigned();
			$table->foreign('familia_id')
						->references('id')->on('familias');
			$table->string('id_animal');
			$table->string('raza');
			$table->string('sexo');
			$table->string('edad');
			$table->string('propietario');
			$table->string('estudios');
			$table->timestamps();
		});

		Schema::create('folios', function($table){
			$table->increments('id');
			$table->string('folio');
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
		Schema::drop('solicitudes');
		Schema::drop('folios');
	}

}
