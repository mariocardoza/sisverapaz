<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NegocioRequest;

// Models
use App\Negocio;
use App\Contribuyente;
use App\Rubro;

class NegocioController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $negocios = Negocio::all();
        return view('negocios.index', compact("negocios"));
    }

    public function guardarContribuyente(Request $request)
    {
        if($request->ajax())
        {
            Contribuyente::create($request->All());
            return response()->json([
                'mensaje' => 'Registro creado']);
        }
    }

    public function listarContribuyentes()
    {
        return Contribuyente::where('estado',1)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rubros = Rubro::pluck('nombre', 'id');
        $contribuyentes = Contribuyente::pluck('nombre', 'id');
        return view('negocios.create', compact('contribuyentes', 'rubros'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $negocio = new Negocio();
      if($request->tipo_cobro==1){
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'capital' => 'required|numeric|min:0.01',
        ]);
        $negocio->capital =$request->capital;
      }else if($request->tipo_cobro==2){
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'licencia' => 'required|numeric|min:0.01',
        ]);
        $negocio->licencia =$request->licencia;
      }
      else if($request->tipo_cobro==3){
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'otro' => 'required|numeric|min:0.01',
        ]);
        $negocio->otro =$request->otro;
      }else{
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'numero_cabezas' => 'required|numeric|min:1',
          'precio_cabezas' => 'required|numeric|min:0.01',
        ]);
        $negocio->es_granja =1;
        $negocio->numero_cabezas =$request->numero_cabezas;
        $negocio->precio_cabezas =$request->precio_cabezas;
      }
        $negocio->tipo_cobro = $request->tipo_cobro;
        $negocio->contribuyente_id = $request->contribuyente_id;
        $negocio->nombre = $request->nombre;
        $negocio->direccion = $request->direccion;
        $negocio->rubro_id = $request->rubro_id;
        $negocio->lat = $request->lat;
        $negocio->lng = $request->lng;
        $negocio->numero_cuenta = 'NG' . strtotime(date('Y-m-d h:m:s'));

        if($negocio->save()) {
            return array(
                "response"  => true,
                "message"   => 'Hemos agregado con exito al nuevo negocio',
                "data"      => Negocio::where('id', $negocio['id'])->with('rubro')->first()
            );
        }else {
            return array(
                "response"  => false,
                "message"   => 'Tenemos problema con el servidor por el momento. intenta mas tarde'
            );
        }
        //Negocio::create($request->All());
        //bitacora('Registró un negocio');
        // return redirect('negocios')->with('mensaje','Registro almacenado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $negocio = Negocio::findorFail($id);
        return view('negocios.show', compact('negocio'));
    }

    public function ubicacion(Request $request)
    {
      try{
        $negocio=Negocio::find($request->id);
        $negocio->lat = $request->lat;
        $negocio->lng = $request->lng;
        $negocio->save();
        return array(1);
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit(Negocio $negocio)
    {
        try{
            $rubros=Rubro::where('estado',1)->get();
            $contribuyentes = Contribuyente::whereEstado(1)->get();
            $modal="";
            $modal.='<div class="modal fade" tabindex="-1" id="modal_enegocio" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="gridSystemModalLabel">Editar un negocio</h4>
                </div>
                <div class="modal-body">
                    <form id="form_enegocio" class="">
                        <div class="row">
                        <div class="col-md-12" style="text-align: center;">
                          <div class="btn-group" data-toggle="buttons">
                              <label class="btn btn-primary active">
                                <input type="radio" name="tipo_cobro_edit" value="1" id="capitall" checked> Capital
                              </label>
                              <label class="btn btn-primary">
                                <input type="radio" name="tipo_cobro_edit" value="2" id="licencia"> Licencia
                              </label>
                              <label class="btn btn-primary">
                                <input type="radio" name="tipo_cobro_edit" value="3" id="otro"> Otro
                              </label>
                              <label class="btn btn-primary">
                                <input type="radio" name="tipo_cobro_edit" value="4" id="ganado"> Ganado
                              </label>
                          </div>
                      </div>
                      <br><br><br>
                          <div class="col-md-12">
                              <div class="form-group">
                              <label for="" class="control-label">Propietario</label>
                              <select name="contribuyente_id" class="chosen-select-width">
                                <option value="">Seleccione un propietario</option>';
                                foreach($contribuyentes as $contribuyente):
                                  if($contribuyente->id==$negocio->contribuyente_id):
                                    $modal.='<option selected value="'.$contribuyente->id.'">'.$contribuyente->nombre.'</option>';
                                  else:
                                    $modal.='<option value="'.$contribuyente->id.'">'.$contribuyente->nombre.'</option>';
                                  endif;
                                endforeach;
                              $modal.='</select>
                              </div>
                            </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label">Nombre</label>
                              <input type="text" value="'.$negocio->nombre.'" name="nombre" autocomplete="off" placeholder="Digite el nombre del negocio" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label tipo_cobro_text">Capital</label>
                              <input type="number" value="'.$negocio->capital.'" name="capital" placeholder="Digite el capital inicial" class="form-control tipo_cobro_field">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label">Rubro</label>
                              <select name="rubro_id" id="" class="chosen-select-width esee">
                                <option value="">Seleccione un rubro</option>';
                                foreach($rubros as $r):
                                    if($negocio->rubro_id==$r->id):
                                        $modal.='<option selected value="'.$r->id.'">'.$r->nombre.'</option>';
                                    else:
                                        $modal.='<option value="'.$r->id.'">'.$r->nombre.'</option>';
                                    endif;
                                endforeach;
                              $modal.='</select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label">Dirección</label>
                              <textarea name="direccion" id="direcc_enegocio" rows="2" class="form-control">'.$negocio->direccion.'</textarea>
                            </div>
                          </div>
                      </div>
                    
                </div>
                <div class="modal-footer">
                  <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="button" data-id="'.$negocio->id.'" class="btn btn-success submit_editarnegocio">Registrar</button></center>
                </div>
              </form>
              </div>
            </div>
          </div>';
          return array(1,"exito",$modal,$negocio);

        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
      $parameters = $request->All();
      $negocio = Negocio::find($id);
      if($request->tipo_cobro==1){
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'capital' => 'required|numeric|min:0.01',
        ]);
        $negocio->capital =$request->capital;
      }else if($request->tipo_cobro==2){
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'licencia' => 'required|numeric|min:0.01',
        ]);
        $negocio->licencia =$request->licencia;
      }
      else if($request->tipo_cobro==3){
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'otro' => 'required|numeric|min:0.01',
        ]);
        $negocio->otro =$request->otro;
      }else{
        $request->validate([
          'nombre' => 'required',
          'contribuyente_id' => 'required',
          'direccion' => 'required',
          'rubro_id' => 'required',
          'numero_cabezas' => 'required|numeric|min:1',
          'precio_cabezas' => 'required|numeric|min:0.01',
        ]);
        $negocio->es_granja =1;
        $negocio->numero_cabezas =$request->numero_cabezas;
        $negocio->precio_cabezas =$request->precio_cabezas;
      }
        $negocio->tipo_cobro = $request->tipo_cobro;
        $negocio->contribuyente_id = $request->contribuyente_id;
        $negocio->nombre = $request->nombre;
        $negocio->direccion = $request->direccion;
        $negocio->rubro_id = $request->rubro_id;
       
      if($negocio->save()){
        return array(
          "response"  => true,
          "message"   => 'Hemos actualizado con exito al negocio',
          "data"      => Negocio::where('id', $negocio['id'])->with('rubro')->first()
        );        
      }else{
        return array(
          "response"  => false,
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
        );
      }
    }

    public function viewMapa($id) {
        $negocio = Negocio::findorFail($id);
        return view('negocios.mapa', compact('negocio'));
    }

    public function mapas(Request $request)
    {
        $all = $request->all();
        $negocio = Negocio::findOrFail($all['id']);
        $negocio->lat = $all['lat'];
        $negocio->lng = $all['lng'];
        $negocio->save();
        return $negocio;        
    }

    public function mapa()
    {
        return view('negocios.mapaGlobal');
    }

    public function mapasAll()
    {
        return Negocio::where('lat', '!=', 0)
            ->where('lng', '!=', 0)
            ->with('contribuyente', 'rubro')->get();
    }

    

    // public function negocioPostControllerAdd (Request $request) {
    //     $parameters = $request->all();
    //     return $parameters;
    // }
}
