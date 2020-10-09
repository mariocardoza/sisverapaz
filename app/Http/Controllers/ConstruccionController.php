<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contribuyente;
use App\Inmueble;
use App\Construccion;
use App\Http\Requests\ConstruccionRequest;
use Validator;

class ConstruccionController extends Controller
{
    private $modal_edit;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $construcciones = Construccion::all();
        return view('construcciones.index',compact('construcciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contribuyentes = Contribuyente::all();
        $impuestos = Impuesto::all();
        $construcciones = Construccion::all();
        return view('construcciones.create',compact('contribuyentes','impuestos','construcciones'));
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
            if($request->presupuesto>0){
                //Construccion::create($request->All());
                bitacora('Registro una construción');
                $sinfiestas=$request->presupuesto*session('construccion');
                $fiestas=$sinfiestas*session('fiestas');
                $total=$sinfiestas+$fiestas;
                
                $construccion=Construccion::create([
                    'contribuyente_id'=>$request->contribuyente_id,
                    'inmueble_id'=>$request->inmueble_id,
                    'direccion_construccion'=>$request->direccion_construccion,
                    'presupuesto'=>$request->presupuesto,
                    'total'=>$total,
                    'fiestas'=>$fiestas,
                    'impuesto'=>$sinfiestas,
                    'detalle'=>$request->detalle,
                ]);
                return array(1,"exito",$construccion);
            }else{
                return array(2,"mensaje","El Presupuesto debe ser mayor a cero");
            }
            
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function inmueble($id){
        $select="";
        $select.='<option value="">Seleccione un inmueble</option>';
        try{
            $contri=Contribuyente::find($id);
            foreach($contri->inmueble as $i){
                $select.='<option data-direccion="'.$i->direccion_inmueble.'" value="'.$i->id.'">'.$i->numero_escritura.'</option>';
            }
            return array(1,"exito",$select);
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
        $c = Construccion::findorFail($id);
        return view('construcciones.show',compact('c'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $construcciones = Construccion::modal_edit($id);
        return $construcciones;
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
            if($request->presupuesto>0){
                //Construccion::create($request->All());
                bitacora('Registro una construción');
                $sinfiestas=$request->presupuesto*retornar_porcentaje('construccion');
                $fiestas=$sinfiestas*retornar_porcentaje('fiestas');
                $total=$sinfiestas+$fiestas;
                
                $construccion=Construccion::find($id);
                $construccion->inmueble_id=$request->inmueble_id;
                $construccion->direccion_construccion=$request->direccion_construccion;
                $construccion->presupuesto=$request->presupuesto;
                $construccion->total=$total;
                $construccion->fiestas=$fiestas;
                $construccion->impuesto=$sinfiestas;
                $construccion->detalle=$request->detalle;
                $construccion->save();
                
                return array(1,"exito",$construccion);
            }else{
                return array(2,"mensaje","El Presupuesto debe ser mayor a cero");
            }
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

    public function recibo()
    {
        $construcciones = Construccion::whereEstado(3)->get();
        return view('construcciones.recibo',compact('construcciones'));
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

    public function cambiarestado(Request $request, $id)
    {
        try{
            $construccion=Construccion::findorFail($id);
            $construccion->estado=$request->estado;
            $construccion->save();
            return array(1,"exito",$construccion);
        }catch(Exception$e){

        }
    }

    protected function validar(array $data)
    {
        return Validator::make($data, [
            'contribuyente_id' => 'required',
            'inmueble_id' => 'required',
            'presupuesto' => 'required',
            'direccion_construccion'=>'required',
        ]);
    }
}
