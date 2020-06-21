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
    public function store(NegocioRequest $request)
    {
        $parameters = $request->all();
        $negocios = Negocio::create([
            'contribuyente_id'  => $parameters['contribuyente_id'],
            'nombre'            => $parameters['nombre'],
            'capital'           => $parameters['capital'],
            'direccion'         => $parameters['direccion'],
            'rubro_id'          => $parameters['rubro_id'],
            'lat'               => $parameters['lat'],
            'lng'               => $parameters['lng']
        ]);

        if($negocios) {
            return array(
                "response"  => true,
                "message"   => 'Hemos agregado con exito al nuevo negocio',
                "data"      => Negocio::where('id', $negocios['id'])->with('rubro')->first()
            );
        }else {
            return array(
                "response"  => false,
                "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
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
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label">Nombre</label>
                              <input type="text" value="'.$negocio->nombre.'" name="nombre" autocomplete="off" placeholder="Digite el nombre del negocio" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label">Capital</label>
                              <input type="number" value="'.$negocio->capital.'" name="capital" placeholder="Digite el capital inicial" class="form-control">
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
          return array(1,"exito",$modal);

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
      $negocio->nombre = $parameters['nombre'];
      $negocio->capital = $parameters['capital'];
      $negocio->rubro_id = $parameters['rubro_id'];
      $negocio->direccion = $parameters['direccion'];

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
