@extends('layouts.default')

@section('content')
	<div class="row">
		<div class="large-12 columns">
			<h1 class="text-center">Administración de Especies.</h1>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="large-9 columns">
			<table id="familias" width="100%">
				<thead>
					<tr>
						<th>Especies</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td>Familias</td>
						<td>Acciones</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="large-2 columns">
			<p class="text-center">Menu</p>
			<div class="text-center">
				<a href="{{{ URL::to('app/familias/create') }}}" class="iframe1"><span class="fa fa-plus"></span> Agregar Especie</a>
			</div>
		</div>
	</div>

@stop

@section('scripts')
	<script type="text/javascript">
		var table;
		$(document).ready(function() {


			// Setup - add a text input to each footer cell
		    $('#familias tfoot td').each( function () {
		        var title = $('#familias thead th').eq( $(this).index() ).text();
		        $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
		    } );

			table = $('#familias').DataTable({
				"sAjaxSource": "{{ URL::to('app/familias/data') }}",
			});

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