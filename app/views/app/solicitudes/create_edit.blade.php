@extends('layouts.default')

@section('content')
	<?php
		if (isset($solicitud)) {
		 	$url = 'app/solicitudes/'.$solicitud->id;
		 	$method = 'put';
		 } else {
		 	$url = 'app/solicitudes/';
		 	$method = 'post';
		 }
	?>

		<div class="page-header">
			<h3>
				{{ $title }}
			</h3>
			<hr>
		</div>


	{{ Form::open(array('url'=>$url, 'method'=>$method, 'data-abide')) }}
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Folio(s): <small>Requerido</small>
						{{ Form::text('folios', Input::old('folios', isset($solicitud)?$solicitud->folios:null), ['required']) }}
					</label>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Fecha de solicitud: <small>Requerido</small>
						{{ Form::text('fecha_solicitud', Input::old('fecha_solicitud', isset($solicitud)?$solicitud->fecha_solicitud:null), ['id'=>'datepicker', 'required']) }}
					</label>
					<small class="error">Este campo es requerido</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Clínica: <small>Requerido</small>
						{{ Form::text('clinica', Input::old('clinica', isset($solicitud)?$solicitud->clinica:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						MVZ: <small>Requerido</small>
						{{ Form::text('mvz', Input::old('mvz', isset($solicitud)?$solicitud->mvz:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido</small>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Teléfono: <small>Requerido</small>
						{{ Form::text('telefono', Input::old('telefono', isset($solicitud)?$solicitud->telefono:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Correo electrónico: <small>Requerido</small>
						{{ Form::text('email', Input::old('email', isset($solicitud)?$solicitud->email:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Fecha y hora de toma de muestra: <small>Requerido</small>
						{{ Form::text('toma_muestra', Input::old('toma_muestra', isset($solicitud)?$solicitud->toma_muestra:null), ['id'=>'datetimepicker', 'required']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Especie: <small>Requerido</small>
						{{ Form::select('familia_id', array('empty'=>'--')+$familia_options, Input::old('familia_id', isset($solicitud)?$solicitud->familia_id:null), ['required',isset($solicitud)?'disabled':'']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Identificación del Animal: <small>Requerido</small>
						{{ Form::text('id_animal', Input::old('id_animal', isset($solicitud)?$solicitud->id_animal:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Raza: <small>Requerido</small>
						{{ Form::text('raza', Input::old('raza', isset($solicitud)?$solicitud->raza:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Sexo: <small>Requerido</small>
						{{ Form::select('sexo', array('empty'=>'--','Macho'=>'Macho','Hembra'=>'Hembra','Macho Castrado'=>'Macho Castrado','Hembra Castrada'=>'Hembra Castrada'), Input::old('sexo', isset($solicitud)?$solicitud->sexo:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Edad: <small>Requerido</small>
						{{ Form::text('edad', Input::old('edad', isset($solicitud)?$solicitud->edad:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Nombre del Propietario: <small>Requerido</small>
						{{ Form::text('propietario', Input::old('propietario', isset($solicitud)?$solicitud->propietario:null), ['required']) }}
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Estudios solicitados: <small>Requerido</small>
						@if (!isset($solicitud))
							{{ Form::select('estudios[]',$estudio_options, Input::old('estudios', isset($solicitud)?$solicitud->estudios:null), ['required','multiple'=>'multiple','id'=>'multiple']) }}
						@else
						<p class="panel">
							{{ $solicitud->estudios }}
						</p>
						@endif
					</label>
					<small class="error">Este campo es requerido.</small>
				</div>
				@if (isset($solicitud))
				<div class="small-8 medium-8 large-8 columns end">
					<label>
						Anamnesis:
						{{ Form::textarea('observacion', Input::old('observacion', isset($observacion)?$observacion->observacion:null),array('rows'=>3)) }}
					</label>
				</div>
				@endif
			</div>

			@if (isset($solicitud))
				<h3>Resultados</h3>


				<?php
					 $estudio = 0;
					 $titulo = 0;
				?>
				<?php  foreach($resultado as $x => $y): ?>
					@if ($estudio !== $y->estudio and ($estudio !== 0 or $estudio !== 1) )
						<?php $estudio = 1; ?>
					@endif

					@if ( $estudio === 1)
							</tbody>
						</table>
						<?php $estudio = 0; ?>
	    		@endif

					@if ( $estudio === 0)
						<hr>
						<h4>	{{{ $y->estudio }}} </h4>
						<?php $estudio = $y->estudio; ?>
					@endif

					@if ($titulo !== $y->titulo and ($titulo !== 0 or $titulo !== 1) )
						<?php $titulo = 1; ?>
					@endif

	        @if ( $titulo === 1)
							</tbody>
						</table>
						<?php $titulo = 0 ?>
	    		@endif
					@if ($titulo === 0)
						<h4>	{{{ $y->titulo }}} </h4>
						<table>
						<thead>
							<th>Nombre</th>
							<th>Valor</th>
							<th>Resultado</th>
							<th>Unidad</th>
							<th>Negrita</th>
						</thead>
						<tbody>
						<?php $titulo = $y->titulo; ?>
					@endif
	        <tr>
	            <td><?=$y->nombre;?></td>
	            <td><?=$y->valor;?></td>
	            <td>{{ Form::text("resultados[$y->id]", Input::old($y->resultado, isset($resultado)?$y->resultado:null)) }} </td>
	            <td><?=$y->unidad;?></td>
	            <td>{{ Form::checkbox("negrita[$y->id]", 'yes', $y->negrita == 1 ? 'checked' : '') }}</td>
	        </tr>
				<?php endforeach;?>
					</tbody>
						</table>
			@endif

			@if (isset($solicitud))
			<div class="large-12 columns">
				<label>
					Observaciónes:
					{{ Form::textarea('observacion2', Input::old('observacion2', isset($observacion)?$observacion->observacion2:null),array('rows'=>3)) }}
				</label>
			</div>
			@endif

			<div class="row">
				{{ Form::submit('Guardar solicitud', ['class'=>'button']) }}
			</div>
	{{ Form::close() }}
@stop

@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{ asset('datetimepicker-master/jquery.datetimepicker.css') }}"/ >
	<script src="{{ asset('datetimepicker-master/jquery.js') }}"></script>
	<script src="{{ asset('datetimepicker-master/jquery.datetimepicker.js') }}"></script>


	<script>
  $(function() {
    $( "#datepicker" ).datetimepicker({
    	timepicker:false,
    	lang:'es',
    	format: "Y-m-d"
    });
  });
  </script>
  <script>
  jQuery('#datetimepicker').datetimepicker({
  	lang:'es',
  	format:'Y-m-d H:i:s'
  });
  </script>


	<link href="{{ asset('fklingler/demo/style.css') }}" media="all" rel="stylesheet" type="text/css">
  <script src="{{ asset('fklingler/jquery.touch-multiselect.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('#multiple').touchMultiSelect({
      	noneButtonText: 'Ninguno'
      });
    });
  </script>

@stop