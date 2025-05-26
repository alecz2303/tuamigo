<?php

class UnidadesController extends AppController {

	/**
	* Unidad Model
	* @var unidad 
	*/

	protected $unidad;

	/*
	* Inject Models
	* @param Unidad $unidad
	*/

	public function __construct(Unidad $unidad)
	{
		parent::__construct();
		$this->unidad = $unidad;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$unidad = $this->unidad->all();

		return View::make('app/unidades/index', compact('unidad'));
	}

	public function data()
	{
		$unidad = Unidad::leftjoin('estudios','estudios.id','=', 'estudio_id')
										->leftjoin('familias','familias.id','=','familia_id')
					  ->select('unidades.id','estudio','familia','titulo', 'nombre','valor','unidad');


        return Datatables::of($unidad)
        ->add_column('actions', '
            {{ Form::open(array(\'method\' => \'DELETE\', \'action\' => array(\'UnidadesController@destroy\', $id))) }}
            <a href="{{{ URL::to(\'app/unidades/\' . $id . \'/edit\' ) }}}" class="iframe1"><span data-tooltip aria-haspopup="true" class="button tiny has-tip" title="Editar"><i class="fa fa-edit fa-2x fa-fw"></i></span></a>
            {{ Form::button(\'<i class="fa fa-trash-o fa-2x fa-fw"></i>\', [\'class\'=>\'tiny alert\',\'type\'=>\'submit\']) }}
            {{ Form::close() }}
        ')	
        ->remove_column('id')

        ->make();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$title = "Agregar Valor ";
		$estudio_options = DB::table('estudios')->orderBy('estudio', 'asc')->lists('estudio','id');
		$familia_options = DB::table('familias')->orderBy('familia', 'asc')->lists('familia','id');
		return View::make('app/unidades/create_edit', compact('title','estudio_options','familia_options'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$s = $this->unidad->create(Input::all());


		  if($s->save())
		  {
		    return Redirect::route('app.unidades.edit', $s->id)
		      ->with('success', 'El nuevo valor se ha agregado');
		  }
		 
		  return Redirect::route('app.unidades.create')
		    ->withInput()
		    ->withErrors($s->errors());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->unidad->find($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$unidad = $this->unidad->find($id);
		$title = "Editar Valor";
		$estudio_options = DB::table('estudios')->orderBy('estudio', 'asc')->lists('estudio','id');
		$familia_options = DB::table('familias')->orderBy('familia', 'asc')->lists('familia','id');
		return View::make('app/unidades/create_edit', compact('unidad','title','estudio_options','familia_options'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$unidad = $this->unidad->find($id);

		$validator = Validator::make(Input::all(), unidad::$rules, unidad::$messages);
		
		$input = array_except(Input::all(), ['_method',]);
	  
	  if($validator->passes())
	  {
	  	$unidad->update($input);
	    return Redirect::route('app.unidades.edit', $id)
	      ->with('success', 'La unidad se ha actualizado');
	  }
	 
	  return Redirect::route('app.unidades.edit', $id)
	    ->withInput()
	    ->withErrors($validator);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Unidad::destroy($id);
		return Redirect::route('app.unidades.index')->with('warning','Se ha eliminado el valor.');
	}

	public function prueba()
	{
		return View::make('app/unidades/prueba');
	}

	public function pruebadata()
	{
		return Unidad::leftjoin('estudios','estudios.id','=', 'estudio_id')
										->leftjoin('familias','familias.id','=','familia_id')
					  ->select('unidades.id','estudio','familia','titulo', 'nombre','valor','unidad')->get();
	}

}
