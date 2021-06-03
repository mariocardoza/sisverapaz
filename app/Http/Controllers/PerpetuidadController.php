<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cementerio;
use App\Contribuyente;
use App\Perpetuidad;
use App\Cuenta;
use App\CuentaDetalle;
use App\PerpetuidadBeneficiario;
Use Validator;

class PerpetuidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titulos=Perpetuidad::all();
        return view('perpetuidad.index',compact('titulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cementerios=Cementerio::all();
        $contribuyentes=Contribuyente::whereEstado(1)->get();
        $beneficiarios=PerpetuidadBeneficiario::whereEstado(1)->get();
        return view('perpetuidad.create',compact('cementerios','contribuyentes','beneficiarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validar_puesto($request->all())->validate();
        try{    
            $t=Perpetuidad::create([
                'costo'=>$request->costo,
                'cementerio_id'=>$request->cementerio_id,
                'contribuyente_id'=>$request->contribuyente_id,
                'fecha_adquisicion'=>\invertir_fecha($request->fecha_adquisicion),
                'norte'=>$request->norte,
                'sur'=>$request->sur,
                'oriente'=>$request->oriente,
                'poniente'=>$request->poniente,
                'ancho'=>$request->ancho,
                'largo'=>$request->largo,
                'tipo'=>$request->tipo,
                'lat'=>$request->lat,
                'lng'=>$request->lng,
                'fiestas'=>el_porcentaje('fiestas'),
            ]);
            return array(1,"exito",$t);

        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function recibos()
    {
        $recibos=Perpetuidad::all();
        return view('perpetuidad.recibos',\compact('recibos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Perpetuidad $perpetuidad)
    {
        $beneficiarios=PerpetuidadBeneficiario::whereEstado(1)->get();
        return view('perpetuidad.show',\compact('perpetuidad','beneficiarios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Perpetuidad $perpetuidad)
    {
        $beneficiarios=PerpetuidadBeneficiario::whereEstado(1)->get();
        $html='<div class="modal fade" id="modal_edit_perpetuidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar</h4>
                </div>
                <div class="modal-body">
                    <form id="form_edit_perpetuidad">
                    <div class="form-group col-sm-12">
                    <label for="" class="control-label">Tipo de nicho</label>
                    <select name="tipo" class="chosen-select-width">
                        <option value="Normal con sótano a contracava">Normal con sótano a contracava</option>
                    </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <span class="text-center">Medidas</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Centímetros de ancho</label>
                        <input type="number" step="any" value="'.$perpetuidad->ancho.'" class="form-control" name="ancho">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Metros de largo</label>
                        <input type="number" step="any" value="'.$perpetuidad->largo.'" class="form-control" name="largo">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Linda al norte</label>
                        <input type="text" list="norte" class="form-control" value="'.$perpetuidad->norte.'" name="norte">
                        <datalist id="norte">';
                            foreach($beneficiarios as $b):
                                $html.='<option value="'.$b->beneficiario.'">';
                            endforeach;
                        $html.='</datalist>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Linda al sur</label>
                        <input type="text" list="sur" class="form-control" value="'.$perpetuidad->sur.'" name="sur">
                        <datalist id="sur">';
                            foreach($beneficiarios as $b):
                                $html.='<option value="'.$b->beneficiario.'">';
                            endforeach;
                        $html.='</datalist>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Linda al oriente</label>
                        <input type="text" list="oriente" class="form-control" value="'.$perpetuidad->oriente.'" name="oriente">
                        <datalist id="oriente">';
                            foreach($beneficiarios as $b):
                                $html.='<option value="'.$b->beneficiario.'">';
                            endforeach;
                        $html.='</datalist>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Linda al poniente</label>
                        <input type="text" list="poniente" class="form-control" value="'.$perpetuidad->poniente.'" name="poniente">
                        <datalist id="poniente">';
                            foreach($beneficiarios as $b):
                                $html.='<option value="'.$b->beneficiario.'">';
                            endforeach;
                        $html.='</datalist>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Valor del título</label>
                        <input type="number" step="any" class="form-control" value="'.$perpetuidad->costo.'" name="costo">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="" class="control-label">Fecha</label>
                        <input type="text" name="fecha_adquisicion" autocomplete="off" value="'.$perpetuidad->fecha_adquisicion->format('d-m-Y').'" class="form-control fechanomayor">
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button id="btn_editp" data-id="'.$perpetuidad->id.'" type="button" class="btn btn-success">Guardar</button>
                    </center>
                </div>
            </div>
        </div>
    </div>';
        return array(1,$perpetuidad,$html);
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
        try{
            $p=Perpetuidad::find($id);
                $p->costo=$request->costo;
                $p->fecha_adquisicion=\invertir_fecha($request->fecha_adquisicion);
                $p->norte=$request->norte;
                $p->sur=$request->sur;
                $p->oriente=$request->oriente;
                $p->poniente=$request->poniente;
                $p->ancho=$request->ancho;
                $p->largo=$request->largo;
                $p->tipo=$request->tipo;
                $p->save();
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

    public function beneficiario(Request $request)
    {
        try{
            $cuantos=PerpetuidadBeneficiario::where('perpetuidad_id',$request->perpetuidad_id)->whereEstado(1)->count();
            if($cuantos<=2){
                PerpetuidadBeneficiario::create([
                    'perpetuidad_id'=>$request->perpetuidad_id,
                    'beneficiario'=>$request->beneficiario,
                    'fecha_entierro'=>\invertir_fecha($request->fecha_entierro)
                ]);
                return array(1);
            }else{
                return array(2,'No se pueden sepultar mas de dos personas en el mismo nicho');
            }
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function cobro(Request $request)
    {
        $factura=Perpetuidad::find($request->id);
        \DB::beginTransaction();
        try{
            $cuenta_origen=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',1)->first();
            if($cuenta_origen){
                $cuenta_origen->monto_inicial=$cuenta_origen->monto_inicial+$factura->costo;
                $cuenta_origen->save();

                $detalle_origen=CuentaDetalle::create([
                    'id'=>CuentaDetalle::retonrar_id_insertar(),
                    'cuenta_id'=>$cuenta_origen->id,
                    'accion'=>'Se recibió la cantidad de $'.$factura->costo.' en concepto de cobro de impuesto por emisión de título a perpetuidad',
                    'tipo'=>1,
                    'monto'=>$factura->costo
                ]);

                $cuenta_fiestas=Cuenta::where('estado',1)->where('anio',date('Y'))->where('tipo_cuenta',2)->first();
                if($cuenta_fiestas){
                    $monto_fiestas=0;
                    $monto_fiestas=round($factura->costo*($factura->fiestas/100),2);
                    $cuenta_fiestas->monto_inicial=$cuenta_fiestas->monto_inicial+$monto_fiestas;
                    $cuenta_fiestas->save();

                    $detalle_origen=CuentaDetalle::create([
                        'id'=>CuentaDetalle::retonrar_id_insertar(),
                        'cuenta_id'=>$cuenta_fiestas->id,
                        'accion'=>'Se recibió la cantidad de $'.$monto_fiestas.' en concepto de cobro de impuesto por emisión de título a perpetuidad',
                        'tipo'=>1,
                        'monto'=>$monto_fiestas
                    ]);
                }

                
                $factura->estado=3;
                //$factura->fecha_pago=date('Y-m-d');
                $factura->save();

                \DB::commit();
            }else{
                \DB::rollback(); 
            }
            return array(1,"exito");
        }catch(Exception $e){
            \DB::rollback();
            return array(-1,"error",$e->getMessage());
        }
    }

    protected function validar_puesto(array $data)
    {
        $mensajes=array(
            'contribuyente_id.required'=>'Seleccione un contribuyente',
            'cementerio_id.required'=>'Seleccione un cementerio',
        );
        return Validator::make($data, [
            'contribuyente_id' => 'required',
            'cementerio_id' => 'required',
            'ancho'=>'required',
            'largo'=>'required',
            'costo'=>'required',
            'fecha_adquisicion'=>'required'

        ],$mensajes);

        
    }
}
