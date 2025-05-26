@extends('layouts.modal')

@section('content')
	
	<?php
		if (isset($estudio)) {
		 	$url = 'app/estudios/'.$estudio->id;
		 	$method = 'put';
		 } else {
		 	$url = 'app/estudios/';
		 	$method = 'post';
		 }
	?>

	{{ Form::open(array('url'=>$url, 'method'=>$method, 'data-abide')) }}
		<label>
			Estudio: <small>Requerido</small>
			{{ Form::text('estudio', Input::old('estudio', isset($estudio)?$estudio->estudio:null), ['required']) }}
		</label>
		<small class="error">Este campo es requerido.</small>

		<label>
			Comentario: 
			{{ Form::textarea('comentario', Input::old('comentario', isset($estudio)?$estudio->comentario:null), ['rows'=>3]) }}
		</label>
		
		{{ Form::submit('Guardar', ['class'=>'button']) }}
	{{ Form::close() }}
@stop