<?php

class FamiliasController extends AppController {

	/**
	* Familia Model
	* @var familia 
	*/

	protected $familia;

	/*
	* Inject Models
	* @param Familia $familia
	*/

	public function __construct(Familia $familia)
	{
		parent::__construct();
		$this->familia = $familia;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$familia = $this->familia->all();

		return View::make('app/familias/index', compact('familia'));
	}

	public function data()
	{
		$familia = DB::table('familias')
					  ->select('id','familia');


        return Datatables::of($familia)
        ->add_column('actions', '
            {{ Form::open(array(\'method\' => \'DELETE\', \'action\' => array(\'FamiliasController@destroy\', $id))) }}
            <a href="{{{ URL::to(\'app/familias/\' . $id . \'/edit\' ) }}}" class="iframe1"><span data-tooltip aria-haspopup="true" class="button tiny has-tip" title="Editar"><i class="fa fa-edit fa-2x fa-fw"></i></span></a>
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
		$title = "Agregar Especie ";
		return View::make('app/familias/create_edit', compact('title'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$s = $this->familia->create(Input::all());


		  if($s->save())
		  {
		    return Redirect::route('app.familias.edit', $s->id)
		      ->with('success', 'La nueva especie se ha agregado');
		  }
		 
		  return Redirect::route('app.familias.create')
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
		return $this->familia->find($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$familia = $this->familia->find($id);
		$title = "Editar Especie";
		return View::make('app/familias/create_edit', compact('familia','title'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$familia = $this->familia->find($id);

		$validator = Validator::make(Input::all(), Familia::$rules, Familia::$messages);
		
		$input = array_except(Input::all(), ['_method',]);
	  
	  if($validator->passes())
	  {
	  	$familia->update($input);
	    return Redirect::route('app.familias.edit', $id)
	      ->with('success', 'La especie se ha actualizado');
	  }
	 
	  return Redirect::route('app.familias.edit', $id)
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
		Familia::destroy($id);
		return Redirect::route('app.familias.index')->with('warning','Se ha eliminado la especie.');
	}


}
