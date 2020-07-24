<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContratacionDirecta;
use App\ContratacionDetalle;
use App\CompraDirecta;
use Validator;
use Storage;
use App\Emergencia;

class DirectaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $html='';
            $compras=ContratacionDirecta::find($request->contratacion_id);
            foreach($compras->materiales  as $i=>$m){
                $html.='<tr>
                <td>'.($i+1).'</td>
                <td>'.$m->material->nombre.'</td>
                <td>'.$m->medida->nombre_medida.'</td>
                <td>'.$m->cantidad.'</td>
                <td>
                    <button data-id="'.$m->id.'" class="btn btn-warning" type="button"><i class="fa fa-edit"></i></button>
                </td>
                </tr>';
            }
            return array(1,"exito",$html);
        }else{
            if(Auth()->user()->hasAnyRole(['uaci','admin']))
            {
                $compras=ContratacionDirecta::get();
            }else{
                $compras=ContratacionDirecta::where('user_id',Auth()->user()->id)->get();
            }
            
            return view('directa.index',\compact('compras'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar($request->all())->validate();
        try{
            $e=Emergencia::whereEstado(1)->first();
            ContratacionDirecta::create([
                'codigo'=>ContratacionDirecta::codigo_proyecto(),
                'numero_proceso'=>$request->numero_proceso,
                'nombre'=>$request->nombre,
                'monto'=>$request->monto,
                'user_id'=>Auth()->user()->id,
                'anio'=>date("Y"),
                'emergencia_id'=>$e->id,
                'cuenta_id'=>$request->cuenta_id,
                'renta'=>$request->renta,
                'total'=>$request->total,
            ]);
            return array(1);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $compra=ContratacionDirecta::find($id);
        return view('directa.show',\compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->validar($request->all())->validate();

        try{
            $d=ContratacionDirecta::find($id);
            $d->fill($request->all());
            $d->save();
            return array(1);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function subir(Request $request)
    {
        $this->validar_subir($request->all())->validate();
        try{
            $archivo="Archivo_".$request->nombre."_".date("Ymdhis").".".$request->file('archivo')->getClientOriginalExtension();
            $request->file('archivo')->storeAs('comprasdirectas/archivos', $archivo);
            $contrato=ContratacionDetalle::create([
              'nombre'=>$request->nombre,
              'archivo'=>$archivo,
              'contratacion_id'=>$request->contratacion_id
            ]);
            return array(1);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function proveedor(Request $request)
    {
        $this->validar_proveedor($request->all())->validate();
        try{
            $compra=ContratacionDirecta::findorFail($request->id);
            $compra->proveedor_id=$request->proveedor_id;
            $proveedor->estado=3;
            $compra->save();
            return array(1,"exito",$compra);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function eldetalle(Request $request)
    {
        $this->validar_detalle($request->all())->validate();
        try{
            $c=CompraDirecta::create([
                'contratacion_id'=>$request->contratacion_id,
                'material_id'=>$request->material_id,
                'unidadmedida_id'=>$request->unidadmedida_id,
                'cantidad'=>$request->cantidad
            ]);
            return array(1,"exito",$c);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function modal_edit($id)
    {
        $html='';
        try{
            $cuentas=\App\Cuenta::whereEstado(1)->get();
            $directa=ContratacionDirecta::find($id);
            $html.='<div class="modal fade" tabindex="-1" id="modal_edit" role="dialog" aria-labelledby="gridSystemModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="gridSystemModalLabel">Editar compra</h4>
                </div>
                <div class="modal-body">
                    <form id="form_ecompra" class="">
                    <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="control-label">Número de la compra</label>
                        <input type="text" class="form-control" value="'.$directa->numero_proceso.'" name="numero_proceso">
                      </div>
                
                      <div class="form-group">
                        <label for="" class="control-label">Monto</label>
                        <input type="number" name="monto" step="any" value="'.$directa->monto.'" class="form-control elmonto">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="control-label">Nombre del proceso</label>
                        <input type="text" name="nombre" value="'.$directa->nombre.'" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="" class="control-label">Cuenta</label>
                        <select name="cuenta_id" id="" class="chosen-select-width">
                          <option value="">Seleccione</option>';
                          foreach ($cuentas as $c):
                            if($c->id==$directa->cuenta_id):
                            $html.='<option selected value="'.$c->id.'">'.$c->nombre.'<option>';
                            else:
                            $html.='<option value="'.$c->id.'">'.$c->nombre.'<option>';
                            endif;
                        endforeach;
                        $html.='</select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <label for="">¿El proceso lleva impuesto sobre la renta?</label>
                      <input type="checkbox" class="renta">
                    </div>
                    <div class="col-md-6 sirenta" style="display: none;">
                      <label for="" class="control-label">Renta</label>
                      <input type="number" step="any" name="renta" value="'.$directa->renta.'" class="form-control larenta">
                    </div>
                    <div class="col-md-6 sirenta" style="display: none;">
                      <label for="" class="control-label">Total</label>
                      <input type="number" name="total" readonly value="'.$directa->total.'" class="form-control total">
                    </div>
                </div>
                    
                </div>
                <div class="modal-footer">
                  <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-success puteditar" data-id="'.$directa->id.'">Editar</button></center>
                </div>
              </form>
              </div>
            </div>
          </div>';
          return array(1,$html);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function eliminar(Request $request)
    {
        try{
            $detalle=ContratacionDetalle::find($request->id);
            Storage::disk('local')->delete('comprasdirectas/archivos/'.$request->archivo);
            $detalle->delete();
          return array(1,"exito",$detalle);
          }catch(Exception $e){
    
          }
    }

    public function bajar($file_name)
    {
        $file = '/comprasdirectas/archivos/' . $file_name;
      //dd($file);
      //$filename = 'test.pdf';
      //$path = storage_path($file);
      $disk = Storage::disk('local');
      if ($disk->exists($file)) {
          $fs = Storage::disk('local')->getDriver();
          $stream = $fs->readStream($file);
          /*return \Response::make(file_get_contents($stream), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
           ]);*/
          return \Response::stream(function () use ($stream) {
              fpassthru($stream);
          }, 200, [
              "Content-Type" => $fs->getMimetype($file),
              "Content-Length" => $fs->getSize($file),
              "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
          ]);
      } else {
        return Redirect::back()->with('error', 'Archivo no encontrado');
          //abort(404, "The backup file doesn't exist.");
      }

    }

    protected function validar_subir(array $data)
    {
        $mensajes=array(
            'nombre.required'=>'El nombre del archivo es obligatorio',
            'archivo.required'=>'Debe adjuntar el contrato',
            'archivo.mimes'=>'Debe adjuntar un archivo con extensión válida',
            'archivo.between'=>'Debe seleccionar un archivo menor a 10MB'
        );
        return Validator::make($data, [
            'nombre' => 'required',
            'archivo'=>'required|mimes:jpeg,png,pdf,jpg,doc,docx,xls,xlsx|between:1,10000'
        ],$mensajes);

        
    }

    protected function validar(array $data)
    {
        $mensajes=array(
            'monto.min'=>'El monto debe ser mayor a cero',
            'cuenta_id.required'=>'Seleccione un cuenta',
            'total.min'=>'El total debe ser mayor a cero',
            'renta.min'=>'La renta debe ser mayor o igual a cero',
        );
        return Validator::make($data, [
            'nombre' => 'required',
            'monto'=>'required|numeric|min:1',
            'cuenta_id'=>'required',
            'renta'=>'required|numeric|min:0',
            'total'=>'required|numeric|min:1',
        ],$mensajes);

        
    }

    protected function validar_proveedor(array $data)
    {
        $mensajes=array(
            'proveedor_id.required'=>'Debe seleccionar un proveedor',
        );
        return Validator::make($data, [
            'proveedor_id' => 'required',
        ],$mensajes);  
    }

    protected function validar_detalle(array $data)
    {
        $mensajes=array(
            'cantidad.required'=>'Debe ingresar la cantidad',
            'material_id.required'=>'Debe seleccionar un material',
            'unidadmedida_id.required'=>'Debe seleccionar la unidad de medida',
        );
        return Validator::make($data, [
            'cantidad' => 'required|numeric|min:1',
            'material_id' => 'required',
            'unidadmedida_id' => 'required',
        ],$mensajes);  
    }
}
