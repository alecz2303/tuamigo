<?php 

/**
* 
*/
class Unidad extends Eloquent
{

	protected $table = 'unidades';
	protected $guarded = array('id');

	public static $rules = [
		'estudio_id' => 'required',
		'unidad' => 'required',
	];

	public static $messages = [
		'estudio_id.required' => 'El campo :attribute es requerido',
		'unidad.required' => 'El campo :attribute es requerido',
	];
	
}