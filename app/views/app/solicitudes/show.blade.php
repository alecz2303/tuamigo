@extends('layouts.default')

@section('content')
	<?php
		 	$url = 'app/solicitudes/send';
		 	$method = 'post';
	?>

		<div class="page-header">
			<div class="panel clearfix">
				<div class="large-6 columns">
					<h3>
						Tu Amigo Laboratorio Clínico
					</h3>
				</div>
				<div class="large-6 columns text-right">
					<img src="{{ asset('images/logota.jpg') }}" alt="">
				</div>
			</div>
			{{ $title }} <br>
			<br>
			<i class="fa fa-book"></i> Folio control interno {{ $solicitud->folios }}
			<hr>
		</div>

	{{ Form::open(array('url'=>$url, 'method'=>$method, 'data-abide')) }}
	{{ Form::hidden('id', $solicitud->id) }}
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Fecha de solicitud:
					</label>
					<p>
						{{ $solicitud->fecha_solicitud }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Clínica:
					</label>
					<p>
						{{ $solicitud->clinica }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						MVZ:
					</label>
					<p>
						{{ $solicitud->mvz }}
					</p>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Teléfono:
					</label>
					<p>
						{{ $solicitud->telefono }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Correo electrónico:
					</label>
					<p>
						{{ $solicitud->email }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Fecha y hora de toma de muestra:
					</label>
					<p>
						{{ $solicitud->toma_muestra }}
					</p>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Especie:
					</label>
					<p>
						{{ $familia->familia }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Identificación del Animal:
					</label>
					<p>
						{{ $solicitud->id_animal }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Raza:
					</label>
					<p>
						{{ $solicitud->raza }}
					</p>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Sexo: <br>
					</label>
					<p>
						{{ $solicitud->sexo }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Edad:
					</label>
					<p>
						{{ $solicitud->edad }}
					</p>
				</div>
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Nombre del Propietario:
					</label>
					<p>
						{{ $solicitud->propietario }}
					</p>
				</div>
			</div>
			<div class="row">
				<div class="small-4 medium-4 large-4 columns">
					<label>
						Estudios solicitados:
						<p>
							{{ $solicitud->estudios }}
						</p>
					</label>
				</div>
				<div class="small-8 medium-8 large-8 columns end">
					<label>
						Anamnesis: <br>
					</label>
					<p>
					{{ $observacion->observacion }}
					</p>
				</div>
			</div>

			<div class="row">
				<div class="large-12 columns">
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
						<h4>	{{{ ucfirst($y->titulo) }}} </h4>
						<table>
						<thead>
							<th>Analito</th>
							<th>Resultado</th>
							<th>Referencia</th>
							<th>Unidad</th>
						</thead>
						<tbody>
						<?php $titulo = $y->titulo; ?>
					@endif
	        <tr>
	        	@if($y->resultado != '')
	            <td><?=$y->nombre;?></td>
	            <td>
	            	@if ($y->negrita == 1)
	            		<span class="alert label">
	            	@else
	            		<span>
	            	@endif
	            		{{ $y->resultado }} </span>
	            </td>
	            <td><?=$y->valor;?></td>
	            <td><?=$y->unidad;?></td>
	          @endif
	        </tr>
				<?php endforeach;?>
					</tbody>
						</table>
			@endif
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<label>
						Observaciones:
					</label>
						<p>
							{{ $observacion->observacion2 }}
						</p>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns panel">
					Responsable. <br>
					M.V.Z. Claudia Maza Santiago. <br>
					Cédula Profesional: 4081748 <br>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					{{ Form::submit('Enviar Correo', ['class'=>'button no-print']) }}
					{{ HTML::link('app/solicitudes/'.$solicitud->id.'/mail', 'Imprimir', array('target'=>'_blank','class'=>'button')) }}
				</div>
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