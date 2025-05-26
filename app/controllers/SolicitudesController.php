<?php

class SolicitudesController extends AppController {

	/**
	* Solicitud Model
	* Folio Model
	* Resultado Model
	* Observacion Model
	* @var solicitud
	* @var Folio
	* @var Resultado
	* @var Observacion
	*/

	protected $solicitud;
	protected $folio;
	protected $resultado;
	protected $observacion;

	/*
	* Inject Models
	* @param Solicitud $solicitud
	* @param Folio $folio
	*/

	public function __construct(Solicitud $solicitud, Folio $folio, Resultado $resultado, Observacion $observacion)
	{
		parent::__construct();
		$this->solicitud = $solicitud;
		$this->folio = $folio;
		$this->resultado = $resultado;
		$this->observacion = $observacion;
	}

	public function data(){
		$solicitud = Solicitud::select('id','folios','folio','fecha_solicitud','clinica', 'mvz')->orderBy('id','desc');


        return Datatables::of($solicitud)
        ->edit_column('folio', '<a href="{{ URL::to(\'app/solicitudes/\' . $id) }}">{{ $folio }}</a>')
        ->add_column('actions', '
            {{ Form::open(array(\'method\' => \'DELETE\', \'action\' => array(\'SolicitudesController@destroy\', $id))) }}
            <a href="{{{ URL::to(\'app/solicitudes/\' . $id . \'/edit\' ) }}}"><span data-tooltip aria-haspopup="true" class="button tiny has-tip" title="Editar"><i class="fa fa-edit fa-2x fa-fw"></i></span></a>
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
		return View::make('app/solicitudes/index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$title = "Agregar Solicitud ";
		$familia_options = DB::table('familias')->orderBy('familia', 'asc')->lists('familia','id');
		$estudio_options = DB::table('estudios')->orderBy('estudio', 'asc')->lists('estudio','id');
		return View::make('app/solicitudes/create_edit', compact('title','familia_options','estudio_options'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$folio = Folio::find(1);
		$num = $folio->folio + 1;
		$num_padded = date("Ymd")."/".sprintf("%06d", $num);
		$s = $this->solicitud->create(Input::except('estudios'));
		$s->folio = $num_padded;
		foreach (Input::get('estudios') as $type => $value) {
			$estudio = Estudio::find($value);
			$s->estudios .= $estudio->estudio."<br>";
		}


		  if($s->save())
		  {
		  	foreach (Input::get('estudios') as $key => $value) {
					$unidades = Unidad::where('familia_id','=',Input::get('familia_id'))
														->where('estudio_id','=',$value)->get();
					$estudio = Estudio::find($value);
					$familia = Familia::find(Input::get('familia_id'));
					foreach ($unidades as $llave => $valor) {
						$resultado = new Resultado;
						$resultado->solicitud_id = $s->id;
						$resultado->estudio = $estudio->estudio;
						$resultado->familia = $familia->familia;
						$resultado->titulo = $valor->titulo;
						$resultado->nombre = $valor->nombre;
						$resultado->valor = $valor->valor;
						$resultado->unidad = $valor->unidad;
						$resultado->save();
					}
				}
				$observacion = new Observacion;
				$observacion->solicitud_id = $s->id;
				$observacion->observacion = "";
				$observacion->observacion2 = "";
				$observacion->save();

				$folio->folio = $num;
				$folio->save();

		    return Redirect::route('app.solicitudes.edit', $s->id)
		      ->with('success', 'El nuevo valor se ha agregado');
		  }

		  return Redirect::route('app.solicitudes.create')
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
		$solicitud = Solicitud::find($id);
		$familia = Familia::where('id','=',$solicitud->familia_id)->first();
		//$resultado = Resultado::where('solicitud_id','=',$id)->orderBy('titulo','desc')->orderBy('nombre')->get();
		$resultado = Resultado::where('solicitud_id','=',$id)->where('resultado','!=','')
		->orderByRaw('
			CASE titulo WHEN "Serie Roja" 	THEN 1
									WHEN "Serie Blanca"	THEN 2
									WHEN "Serie Plaquetaria"	THEN 3
									WHEN "Mielocitos" THEN 4
			END
			')->orderByRaw('
					CASE nombre WHEN "Hematócrito" THEN 1
											WHEN "Hemoglobina" THEN 2
											WHEN "Eritrocitos" THEN 3
											WHEN "Volumen globular medio (VGM)" THEN 4
											WHEN "Volumen globular medio (VCM)" THEN 4
											WHEN "Hemoglobina globular medio (HGM)" THEN 5
											WHEN "Concentración media de hemoglobina globular (CMHC)" THEN 6
											WHEN "Concentración media de hemoglobina globular" THEN 6
											WHEN "Reticulocitos" THEN 7
											WHEN "Leucocitos totales" THEN 8
											WHEN "Leucocitos" THEN 8
											WHEN "Neutrófilos segmentados" THEN 9
											WHEN "Bandas" THEN 10
											WHEN "Monocitos" THEN 11
											WHEN "Linfocitos" THEN 12
											WHEN "Eosinófilos" THEN 13
											WHEN "Basófilos" THEN 14
											WHEN "Mielocitos" THEN 15
					END
			')
		->get();
		$observacion = Observacion::where('solicitud_id','=',$id)->first();
		$title = "<i class='fa fa-book'></i> Resultados Análisis Clinicos Folio: ".$solicitud->folio;
		$familia_options = DB::table('familias')->orderBy('familia', 'asc')->lists('familia','id');
		$estudio_options = DB::table('estudios')->orderBy('estudio', 'asc')->lists('estudio','id');
		return View::make('app.solicitudes.show', compact('familia','title','familia_options','estudio_options','solicitud','resultado','observacion'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$solicitud = Solicitud::find($id);
		//$resultado = Resultado::where('solicitud_id','=',$id)->orderBy('id')->get();
		$resultado = Resultado::where('solicitud_id','=',$id)->orderByRaw('
			CASE titulo WHEN "Serie Roja" 	THEN 1
									WHEN "Serie Blanca"	THEN 2
									WHEN "Serie Plaquetaria"	THEN 3
									WHEN "Mielocitos" THEN 4
			END
			')->orderByRaw('
					CASE nombre WHEN "Hematócrito" THEN 1
											WHEN "Hemoglobina" THEN 2
											WHEN "Eritrocitos" THEN 3
											WHEN "Volumen globular medio (VGM)" THEN 4
											WHEN "Volumen globular medio (VCM)" THEN 4
											WHEN "Hemoglobina globular medio (HGM)" THEN 5
											WHEN "Concentración media de hemoglobina globular (CMHC)" THEN 6
											WHEN "Concentración media de hemoglobina globular" THEN 6
											WHEN "Reticulocitos" THEN 7
											WHEN "Leucocitos totales" THEN 8
											WHEN "Leucocitos" THEN 8
											WHEN "Neutrófilos segmentados" THEN 9
											WHEN "Bandas" THEN 10
											WHEN "Monocitos" THEN 11
											WHEN "Linfocitos" THEN 12
											WHEN "Eosinófilos" THEN 13
											WHEN "Basófilos" THEN 14
											WHEN "Mielocitos" THEN 15
					END
			')
		->get();
		$observacion = Observacion::where('solicitud_id','=',$id)->first();
		$title = "Editar Solicitud Folio: ".$solicitud->folio;
		$familia_options = DB::table('familias')->orderBy('familia', 'asc')->lists('familia','id');
		$estudio_options = DB::table('estudios')->orderBy('estudio', 'asc')->lists('estudio','id');
		return View::make('app/solicitudes/create_edit', compact('title','familia_options','estudio_options','solicitud','resultado','observacion'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

		$solicitud = $this->solicitud->find($id);

		$validator = Validator::make(Input::all(), Solicitud::$rules, Solicitud::$messages);

		$input = array_except(Input::all(), ['_method','resultados','observacion','observacion2','negrita']);

	  foreach (Input::get('resultados') as $key => $value) {
	  	$resultado = $this->resultado->find($key);
	  	$resultado->resultado = $value;
	  	$resultado->save();
	  }

	  $negrita = Solicitud::find($id)->resultado;
	  foreach ($negrita as $value) {
	  	$value->negrita = 0;
	  	$value->save();
	  }

	  if(Input::get('negrita')){
		  foreach (Input::get('negrita') as $key => $value) {
		  	$resultado = $this->resultado->find($key);
		  	$resultado->negrita = 1;
		  	$resultado->save();
		  }
		}
		//dump(Input::get('negrita'));

	  $observacion = Observacion::where('solicitud_id','=',$id)->first();
	  $observacion->observacion = Input::get('observacion');
	  $observacion->observacion2 = Input::get('observacion2');
	  $observacion->save();

	  if($validator->passes())
	  {
	  	$solicitud->update($input);
	    return Redirect::route('app.solicitudes.edit', $id)
	      ->with('success', 'El Estudio se ha actualizado');
	  }

	  return Redirect::route('app.solicitudes.edit', $id)
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
		Solicitud::destroy($id);
		Resultado::where('solicitud_id','=',$id)->delete();
		return Redirect::route('app.solicitudes.index')->with('warning','Se ha eliminado el Estudio.');
	}

	public function viewMail($solicitud)
	{
		//return dump($solicitud);

		$id = $solicitud->id;
		$solicitud = Solicitud::find($id);
		$familia = Familia::where('id','=',$solicitud->familia_id)->first();
		//$resultado = Resultado::where('solicitud_id','=',$id)->orderBy('id')->get();
		$resultado = Resultado::where('solicitud_id','=',$id)->where('resultado','!=','')
		->orderByRaw('
			CASE titulo WHEN "Serie Roja" 	THEN 1
									WHEN "Serie Blanca"	THEN 2
									WHEN "Serie Plaquetaria"	THEN 3
									WHEN "Mielocitos" THEN 4
			END
			')->orderByRaw('
					CASE nombre WHEN "Hematócrito" THEN 1
											WHEN "Hemoglobina" THEN 2
											WHEN "Eritrocitos" THEN 3
											WHEN "Volumen globular medio (VGM)" THEN 4
											WHEN "Volumen globular medio (VCM)" THEN 4
											WHEN "Hemoglobina globular medio (HGM)" THEN 5
											WHEN "Concentración media de hemoglobina globular (CMHC)" THEN 6
											WHEN "Concentración media de hemoglobina globular" THEN 6
											WHEN "Reticulocitos" THEN 7
											WHEN "Leucocitos totales" THEN 8
											WHEN "Leucocitos" THEN 8
											WHEN "Neutrófilos segmentados" THEN 9
											WHEN "Bandas" THEN 10
											WHEN "Monocitos" THEN 11
											WHEN "Linfocitos" THEN 12
											WHEN "Eosinófilos" THEN 13
											WHEN "Basófilos" THEN 14
											WHEN "Mielocitos" THEN 15
					END
			')
		->get();
		$observacion = Observacion::where('solicitud_id','=',$id)->first();
		$title = "Resultados An&aacute;lisis Clinicos Folio: <b>".$solicitud->folio."</b>";
		$familia_options = DB::table('familias')->orderBy('familia', 'asc')->lists('familia','id');
		$estudio_options = DB::table('estudios')->orderBy('estudio', 'asc')->lists('estudio','id');
		$html = View::make('app.solicitudes.viewmail', compact('familia','title','familia_options','estudio_options','solicitud','resultado','observacion'));

		return $html;

	}

	public function send()
	{


		$id = Input::get('id');
		$solicitud = Solicitud::find($id);
		$familia = Familia::where('id','=',$solicitud->familia_id)->first();
		//$resultado = Resultado::where('solicitud_id','=',$id)->orderBy('id')->get();
		$resultado = Resultado::where('solicitud_id','=',$id)->where('resultado','!=','')
		->orderByRaw('
			CASE titulo WHEN "Serie Roja" 	THEN 1
									WHEN "Serie Blanca"	THEN 2
									WHEN "Serie Plaquetaria"	THEN 3
									WHEN "Mielocitos" THEN 4
			END
			')->orderByRaw('
					CASE nombre WHEN "Hematócrito" THEN 1
											WHEN "Hemoglobina" THEN 2
											WHEN "Eritrocitos" THEN 3
											WHEN "Volumen globular medio (VGM)" THEN 4
											WHEN "Volumen globular medio (VCM)" THEN 4
											WHEN "Hemoglobina globular medio (HGM)" THEN 5
											WHEN "Concentración media de hemoglobina globular (CMHC)" THEN 6
											WHEN "Concentración media de hemoglobina globular" THEN 6
											WHEN "Reticulocitos" THEN 7
											WHEN "Leucocitos totales" THEN 8
											WHEN "Leucocitos" THEN 8
											WHEN "Neutrófilos segmentados" THEN 9
											WHEN "Bandas" THEN 10
											WHEN "Monocitos" THEN 11
											WHEN "Linfocitos" THEN 12
											WHEN "Eosinófilos" THEN 13
											WHEN "Basófilos" THEN 14
											WHEN "Mielocitos" THEN 15
					END
			')
		->get();
		$observacion = Observacion::where('solicitud_id','=',$id)->first();
		$title = "Resultados An&aacute;lisis Clinicos Folio: <b>".$solicitud->folio."</b>";
		$familia_options = DB::table('familias')->orderBy('familia', 'asc')->lists('familia','id');
		$estudio_options = DB::table('estudios')->orderBy('estudio', 'asc')->lists('estudio','id');
		$html = View::make('app.solicitudes.mail', compact('familia','title','familia_options','estudio_options','solicitud','resultado','observacion'));


		$headers = array('Content-Type' => 'application/pdf');
		//return Response::make(PDF::load($html, 'letter', 'portrait')->show('my_pdf'), 200, $headers);


		define('ESTUDIOS_DIR', public_path('uploads/estudios')); // I define this in a constants.php file

		if (!is_dir(ESTUDIOS_DIR)){
		    mkdir(ESTUDIOS_DIR, 0755, true);
		}

		$data=array(
			'nombre'  => $solicitud->mvz,
			'clinica' => $solicitud->clinica,
			'mascota' => $solicitud->id_animal
		);

		$outputName = str_random(10); // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
		$pdfPath = ESTUDIOS_DIR.'/'.$outputName.'.pdf';
		File::put($pdfPath, PDF::load($html, 'letter', 'portrait')->output());

		Mail::send('emails.pdf', $data, function($message) use ($pdfPath,$solicitud){
		    $message->from('analisis@analisistuamigo.com', 'Tu Amigo Laboratorio Clínico');
		    $message->subject('Resultados de <<'.$solicitud->id_animal.'>>, "TU AMIGO LABORATORIO CLÍNICO"');
		    $message->to($solicitud->email);
		    $message->cc('mazaclaudia82@gmail.com');
		    $message->cc('labvet@analisistuamigo.com');
		    $message->attach($pdfPath, array('as'=>'Resultados.pdf'));
		});
		echo $pdfPath;

		return Redirect::route('app.solicitudes.index')->with('success','Se ha enviado el Resultado con éxito.');

	}

}
