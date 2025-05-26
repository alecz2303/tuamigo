@extends('layouts.modal')

@section('content')
	
	<?php
		if (isset($unidad)) {
		 	$url = 'app/unidades/'.$unidad->id;
		 	$method = 'put';
		 } else {
		 	$url = 'app/unidades/';
		 	$method = 'post';
		 }
	?>

	{{ Form::open(array('url'=>$url, 'method'=>$method, 'data-abide')) }}
		
		<label>
			Estudio: <small>Requerido</small>
			{{ Form::select('estudio_id', array('empty'=>'--')+$estudio_options , Input::old('estudio_id', isset($unidad) ? $unidad->estudio_id : null),['required'=>'']) }}
			
		</label>
		<small class="error">Este campo es requerido.</small>

		<label>
			Familia: <small>Requerido</small>
			{{ Form::select('familia_id', array('empty'=>'--')+$familia_options, Input::old('familia_id', isset($unidad)?$unidad->familia_id:null), ['required']) }}
		</label>
		<small class="error">Este campo es requerido.</small>

		<label>
			Título: <small>Requerido</small>
			{{ Form::text('titulo', Input::old('titulo', isset($unidad)?$unidad->titulo:null), ['required']) }}
		</label>
		<small class="error">Este campo es requerido.</small>

		<label>
			Nombre: <small>Requerido</small>
			{{ Form::text('nombre', Input::old('nombre', isset($unidad)?$unidad->nombre:null), ['required']) }}
		</label>
		<small class="error">Este campo es requerido.</small>

		<label>
			Valor: <small>Requerido</small>
			{{ Form::text('valor', Input::old('valor', isset($unidad)?$unidad->valor:null), ['required']) }}
		</label>
		<small class="error">Este campo es requerido.</small>

		<label>
			Unidad: <small>Requerido</small>
			{{ Form::text('unidad', Input::old('unidad', isset($unidad)?$unidad->unidad:null), ['required']) }}
		</label>
		<small class="error">Este campo es requerido.</small>
		
		{{ Form::submit('Guardar', ['class'=>'button']) }}
	{{ Form::close() }}
@stop