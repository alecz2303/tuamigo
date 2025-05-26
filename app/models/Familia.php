<?php 

/**
* 
*/
class Familia extends Eloquent
{
	
	protected $guarded = array('id');

	public static $rules = [
		'familia' => 'required',
	];

	public static $messages = [
		'familia.required' => 'El campo :attribute es requerido',
	];

}