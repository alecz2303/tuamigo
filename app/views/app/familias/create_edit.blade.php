@extends('layouts.modal')

@section('content')
	
	<?php
		if (isset($familia)) {
		 	$url = 'app/familias/'.$familia->id;
		 	$method = 'put';
		 } else {
		 	$url = 'app/familias/';
		 	$method = 'post';
		 }
	?>

	{{ Form::open(array('url'=>$url, 'method'=>$method, 'data-abide')) }}
		<label>
			Especie: <small>Requerido</small>
			{{ Form::text('familia', Input::old('familia', isset($familia)?$familia->familia:null), ['required']) }}
		</label>
		<small class="error">Este campo es requerido.</small>

		
		{{ Form::submit('Guardar', ['class'=>'button']) }}
	{{ Form::close() }}
@stop