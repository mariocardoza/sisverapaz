<?php

namespace App\Http\Controllers;

use App\Inmueble;
use Illuminate\Http\Request;
use Validator;
use App\Factura;

class InmuebleController extends Controller
{

    public function removeTipoServicioInmueble(Request $request)
    {
        $parameters = $request->all();
        $inmueble = Inmueble::find($parameters['id']);
        if($inmueble->tipoServicio()->detach($parameters['idTipoServicio'])){
            return array(
                'response' => true,
                'message'  => 'La peticion fue realizada con exito'
            );
        }else{
            return array(
                'response' => false,
                'message'  => 'Tenemos un problema con el servidor por el momento, intenta mas tarde.'
            );
        }
    }
    public function addTipoServicioInmueble(Request $request)
    {
        $parameters = $request->all();
        
        $inmueble = Inmueble::find($parameters['id']);
        $tipoServicio = \App\Tiposervicio::find($parameters['idTipoServicio']);

        if($inmueble->tipoServicio->contains($tipoServicio)){
            return array(
                'response' => false,
                'message' => 'Lo sentimos pero no puedes agregar dos veces el mismo impuesto'
            );
        }else{
            $inmueble->tipoServicio()->save($tipoServicio);
            return array(
                'response' => true,
                'data'     => $tipoServicio,
                'message'  => 'Hemos agregado con exito el impuesto a este inmueble.'
            );
        }
    }

    public function quitarservicioinmueble(Request $request)
    {
        try{
            $inmueble = Inmueble::find($request['id']);
            //$inmueble->tipoServicio()->detach();
            \DB::table('inmueble_tiposervicio')->where('id' , $request->idTipoServicio)->delete();
            return array(1,"exito",$inmueble);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all  = $request->all();
        $contribuyente = \App\Contribuyente::find($all['contribuyente']);
        
        $inmueble    = new Inmueble();
        $inmueble->estado = 1;
        $inmueble->latitude            = $all['object']['latitude'];
        $inmueble->longitude           = $all['object']['longitude'];
        $inmueble->metros_acera        = $all['object']['metros_acera'];
        $inmueble->ancho_inmueble      = $all['object']['ancho_inmueble'];
        $inmueble->largo_inmueble      = $all['object']['largo_inmueble'];
        $inmueble->numero_escritura    = $all['object']['numero_escritura'];
        $inmueble->numero_catastral    = $all['object']['numero_catastral'];
        $inmueble->direccion_inmueble  = $all['object']['direccion_inmueble'];
        $inmueble->contribuyente_id    = $all['contribuyente'];
        $isTrueOrFalse = $contribuyente->inmuebles()->save($inmueble);

        if($isTrueOrFalse) {
          return array(
            'response' => true,
            "inmueble" => $inmueble
          );
        }else{
          return array(
            'response' => false,
            'message' => 'Lo sentimos pero no puedes agregar dos veces el inmueble'
          );
        }
    }

    public function guardar(Request $request)
    {
        $this->validar($request->all())->validate();
        try{
            $inmueble    = new Inmueble();
            $inmueble->estado = 1;
            $inmueble->latitude            = $request['lat'];
            $inmueble->longitude           = $request['lng'];
            $inmueble->metros_acera        = $request['metros_acera'];
            $inmueble->ancho_inmueble      = $request['ancho_inmueble'];
            $inmueble->largo_inmueble      = $request['largo_inmueble'];
            $inmueble->numero_escritura    = $request['numero_escritura'];
            $inmueble->numero_catastral    = $request['numero_catastral'];
            $inmueble->direccion_inmueble  = $request['direccion_inmueble'];
            $inmueble->contribuyente_id    = $request['contribuyente_id'];
            $inmueble->save();
            return array(1,"exito",$inmueble);
        }catch(Exception $e){
            return array(-1,"error",$e->getMEssage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function show(Inmueble $inmueble)
    {
        return $inmueble->load(['tipoServicio']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function edit(Inmueble $inmueble)
    {
        $modal="";
        try{
            $modal.='<div class="modal fade" tabindex="-1" id="modal_einmueble" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="gridSystemModalLabel">Editar un inmueble</h4>
                </div>
                <div class="modal-body">
                    <form id="form_einmueble" class="">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label"># Catastral</label>
                              <input type="text" name="numero_catastral" value="'.$inmueble->numero_catastral.'" autocomplete="off" placeholder="Digite el número catastral" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="" class="control-label">Ancho inmueble (mts)</label>
                                  <input type="number" value="'.$inmueble->ancho_inmueble.'" name="ancho_inmueble" placeholder="Digite el ancho" class="form-control">
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="" class="control-label">Largo inmueble (mts)</label>
                                  <input type="number" name="largo_inmueble" value="'.$inmueble->largo_inmueble.'" placeholder="Digite el largo" class="form-control">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label"># Escritura</label>
                              <input type="text" name="numero_escritura" value="'.$inmueble->numero_escritura.'" autocomplete="off" placeholder="Digite el número de escritura" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="" class="control-label">Metros de acera</label>
                              <input type="text" name="metros_acera" value="'.$inmueble->metros_acera.'" autocomplete="off" placeholder="Digite la longitud de la acera (mts)" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-12">
          
                            <div class="form-group">
                              <label for="" class="control-label">Dirección</label>
                              <textarea class="form-control" name="direccion_inmueble" id="" rows="2">'.$inmueble->direccion_inmueble.'</textarea>
                            </div>
                          </div>
            
                      </div>
                    
                </div>
                <div class="modal-footer">
                  <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="button" data-id="'.$inmueble->id.'" class="btn btn-success submit_editinmueble">Registrar</button></center>
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
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inmueble $inmueble)
    {
      $all = $request->all();

      $inmueble->metros_acera = $all['metros_acera'];
      $inmueble->ancho_inmueble = $all['ancho_inmueble'];
      $inmueble->largo_inmueble = $all['largo_inmueble'];
      $inmueble->numero_catastral = $all['numero_catastral'];
      $inmueble->numero_escritura = $all['numero_escritura'];
      $inmueble->direccion_inmueble = $all['direccion_inmueble'];
      
      if($inmueble->save()) {
          return array(1,"exito");
        }else{
          return array(
            'response' => false,
            'message' => 'Lo sentimos pero no puedes agregar dos veces el mismo impuesto'
          );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $inmueble = Inmueble::find($id)->update([
            'estado' => intval($request->get('estado'))
        ]);
        return "{ 'message' : 'Todo esta correcto' }";
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'ancho_inmueble.required'=>'El ancho del inmueble obligatorio',
            'largo_inmueble.required'=>'El largo del inmueble obligatorio',
            'numero_escritura.required'=>'El número de la escritura del inmueble obligatorio',
            'unidad_id.required'=>'La unidad de medida es obligatoria',
            'categoria_id.required'=>'La categoría es obligatoria',
        );
        return Validator::make($data, [
            'contribuyente_id' => 'required',
            'numero_catastral' => 'required',
            'ancho_inmueble'=>'required|numeric',
            'largo_inmueble'=>'required|numeric',
            'numero_escritura'=>'required',
            'metros_acera'=>'required|numeric',
        ],$mensajes);
    }

    public function impuestos_inmueble($id)
    {
        $inmueble=Inmueble::find($id);
       
        $servicios= \DB::table('tiposervicios as ts')
        ->whereNotExists(function ($query) use ($id)  {
             $query->from('inmueble_tiposervicio as its')
                ->whereRaw('its.tiposervicio_id = ts.id')
                ->whereRaw('its.inmueble_id ='.$id);
            })->get();
        $html="";
        $select="<option value=''>Seleccione..</option>";
        foreach($inmueble->tiposervicio as $i => $t){
            $html.='<tr>
              <td>'.($i+1).'</td>
              <td><span>'.$t->nombre.'</span></td>
              <td><span>$'.number_format($t->costo,2).'</span></td>
              <td>
                <div class="btn-group">';
                  $html.='<button type="button" data-servicio="'.$t->pivot->id.'" data-inmueble="'.$id.'" id="quitar_r" class="btn btn-danger quitaimpuesto">
                    <i class="fa fa-minus-circle"></i>
                  </button>';
                $html.='</div>
              </td>
            </tr>';
        }
        foreach($servicios as $s){
            $select.='<option value="'.$s->id.'">'.$s->nombre.'</option>';
        }
        
        return array(1,$inmueble,$html,$select);
    }

    public function buscarInmueble(Request $request){
      return Inmueble::where('contribuyente_id',$request['id'])->where('estado',1)->get(['id','direccion_inmueble']);
    }
    public function buscarFactura(Request $request){
      return Factura::where('mueble_id',$request['id'])->where('estado',1)->get(['id','mesYear']);
    }
}