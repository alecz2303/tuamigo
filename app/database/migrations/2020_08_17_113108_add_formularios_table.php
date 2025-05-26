<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormulariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('formularios', function($table){
			$table->increments('id');
			$table->date('fecha_solicitud');
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
			$table->string('anamnesis');
			$table->text('estudios');
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
		Schema::drop('formularios');
	}

}
