<?php

class EstudiosController extends AppController {

	/**
	* Estudio Model
	* @var estudio 
	*/

	protected $estudio;

	/*
	* Inject Models
	* @param Estudio $estudio
	*/

	public function __construct(Estudio $estudio)
	{
		parent::__construct();
		$this->estudio = $estudio;
	}

	public function data()
	{
		$estudio = DB::table('estudios')
					  ->select('id','estudio','comentario');


        return Datatables::of($estudio)
        ->add_column('actions', '
            {{ Form::open(array(\'method\' => \'DELETE\', \'action\' => array(\'EstudiosController@destroy\', $id))) }}
            <a href="{{{ URL::to(\'app/estudios/\' . $id . \'/edit\' ) }}}" class="iframe1"><span data-tooltip aria-haspopup="true" class="button tiny has-tip" title="Editar"><i class="fa fa-edit fa-2x fa-fw"></i></span></a>
            {{ Form::button(\'<i class="fa fa-trash-o fa-2x fa-fw"></i>\', [\'class\'=>\'tiny alert\',\'type\'=>\'submit\']) }}
            {{ Form::close() }}
        ')	
        ->remove_column('id')

        ->make();
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$estudio = $this->estudio->all();

		return View::make('app/estudios/index', compact('estudio'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$title = "Agregar Estudio ";
		return View::make('app/estudios/create_edit', compact('title'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$s = $this->estudio->create(Input::all());


		  if($s->save())
		  {
		    return Redirect::route('app.estudios.edit', $s->id)
		      ->with('success', 'El nuevo estudio se ha agregado');
		  }
		 
		  return Redirect::route('app.estudios.create')
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
		return $this->estudio->find($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$estudio = $this->estudio->find($id);
		$title = "Editar Estudio";
		return View::make('app/estudios/create_edit', compact('estudio','title'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$estudio = $this->estudio->find($id);

		$validator = Validator::make(Input::all(), Estudio::$rules, Estudio::$messages);
		
		$input = array_except(Input::all(), ['_method',]);
	  
	  if($validator->passes())
	  {
	  	$estudio->update($input);
	    return Redirect::route('app.estudios.edit', $id)
	      ->with('success', 'El estudio se ha actualizado');
	  }
	 
	  return Redirect::route('app.estudios.edit', $id)
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
		Estudio::destroy($id);
		return Redirect::route('app.estudios.index')->with('warning','Se ha eliminado el estudio.');
	}


}
