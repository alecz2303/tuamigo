@extends('layouts.default')

@section('content')
	<div class="row">
		<div class="large-12 columns">
			<h1 class="text-center">Solicitudes de Estudios.</h1>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="large-10 columns">
			<table id="solicitudes" width="100%">
				<thead>
					<tr>
						<th>Folio Interno</th>
						<th>Folio</th>
						<th>Fecha Solicitud</th>
						<th>Clínica</th>
						<th>MVZ</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td>Folio Interno</td>
						<td>Folio</td>
						<td>Fecha Solicitud</td>
						<td>Clínica</td>
						<td>MVZ</td>
						<td>Acciones</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="large-2 columns">
			<p class="text-center">Menu</p>
			<div class="text-center">
				<a href="{{{ URL::to('app/solicitudes/create') }}}" ><span class="fa fa-plus"></span> Agregar Solicitud</a>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		var table;
		$(document).ready(function() {


			// Setup - add a text input to each footer cell
		    $('#solicitudes tfoot td').each( function () {
		        var title = $('#solicitudes thead th').eq( $(this).index() ).text();
		        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
		    } );

			table = $('#solicitudes').DataTable({
				"sAjaxSource": "{{ URL::to('app/solicitudes/data') }}",
				"serverSide": true,
			});
			table.column('1:visible').order('desc')

			// Apply the search
		    table.columns().eq( 0 ).each( function ( colIdx ) {
		        $( 'input', table.column( colIdx ).footer() ).on( 'keyup change', function () {
		            table
		                .column( colIdx )
		                .search( this.value )
		                .draw();
		        } );
		    } );
		});
	</script>
@stop