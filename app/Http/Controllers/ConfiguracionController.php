<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;
use App\Porcentaje;
use App\Retencion;
use Validator;
class ConfiguracionController extends Controller
{
    public function create()
    {
      $porcentajes=Porcentaje::all();
      $retenciones=Retencion::all();
      $configuraciones = Configuracion::first();

      return view('configuraciones.create',compact('configuraciones','porcentajes','retenciones'));
    }

    public function alcaldia(Request $request)
    {
      $this->validar_alcaldia($request->all())->validate();
      Configuracion::create([
        "direccion_alcaldia" => $request->direccion_alcaldia,
        "nit_alcaldia" => $request->nit_alcaldia,
        "telefono_alcaldia" => $request->telefono_alcaldia,
        "fax_alcaldia" => $request->fax_alcaldia,
        "email_alcaldia" => $request->email_alcaldia
      ]);
      return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');
    }

    public function porcentajes(Request $request)
    {
      try{
        $porcentaje=Porcentaje::find($request->id);
        $porcentaje->porcentaje=$request->porcentaje;
        $porcentaje->save();

        $porcentajes=Porcentaje::all();
        foreach($porcentajes as $p){
            session([$p->nombre_simple => $p->porcentaje/100]);
        }
        return array(1,"exito");
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public function retenciones(Request $request)
    {
      try{
        $retencione=Retencion::find($request->id);
        $retencione->porcentaje=$request->porcentaje;
        $retencione->save();
        return array(1,"exito");
      }catch(Exception $e){
        return array(-1,"error",$e->getMessage());
      }
    }

    public function ualcaldia(Request $request,$id)
    {
      $configuracion=Configuracion::find($id);
      $configuracion->direccion_alcaldia=$request->direccion_alcaldia;
      $configuracion->nit_alcaldia=$request->nit_alcaldia;
      $configuracion->telefono_alcaldia=$request->telefono_alcaldia;
      $configuracion->fax_alcaldia=$request->fax_alcaldia;
      $configuracion->email_alcaldia=$request->email_alcaldia;
      $configuracion->save();
      return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');

    }

    public function alcalde(Request $request)
    {
      $this->validar_alcalde($request->all())->validate();
          Configuracion::create([
          'nombre_alcalde' => $request->nombre_alcalde,
          'nacimiento_alcalde' => invertir_fecha($request->nacimiento_alcalde),
          'dui_alcalde' => $request->dui_alcalde,
          'nit_alcalde' => $request->nit_alcalde,
          'domicilio_alcalde' => $request->domicilio_alcalde,
          'oficio_alcalde' => $request->oficio_alcalde
        ]);
      return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');

    }

    public function ualcalde(Request $request,$id)
    {
        $configuracion = Configuracion::find($id);
        $configuracion->nombre_alcalde=$request->nombre_alcalde;
        $configuracion->nacimiento_alcalde = invertir_fecha($request->nacimiento_alcalde);
        $configuracion->dui_alcalde = $request->dui_alcalde;
        $configuracion->nit_alcalde = $request->nit_alcalde;
        $configuracion->domicilio_alcalde = $request->domicilio_alcalde;
        $configuracion->oficio_alcalde = $request->oficio_alcalde;
        $configuracion->save();
      return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');

    }

    public function logo(Request $request,$id)
    {
      try{
        $configuracion = \App\Configuracion::find($id);
        /*if($configuracion->escudo_alcaldia!=''){
          if($configuracion->escudo_alcaldia!=$request->file('logo')->getClientOriginalName()){
            unlink('img/logos/'.$configuracion->escudo_alcaldia);
            $request->file('logo')->move('img/logos', $request->file('logo')->getClientOriginalName());
            $configuracion->escudo_alcaldia=$request->file('logo')->getClientOriginalName();
            $configuracion->save();
          }
        }else{*/
          $archivo="logo_alcaldia_".date("Y-m-d-h-i-s-a").".".$request->file('logo')->getClientOriginalExtension();
          //$request->file('logo')->storeAs('logos/', $archivo);
          $request->file('logo')->move('img/logos', $archivo);
          $configuracion->escudo_alcaldia=$archivo;
          $configuracion->save();
        //}
        
        return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');
      }catch(Exception $e){
        return redirect('configuraciones')->with('error','Ocurrió un error al subir la imagen');
      }
      
    }

    public function limitesproyecto(Request $request)
    {
      Configuracion::create([
        'libre_gestion' => $request->libre_gestion,
        'licitacion' => invertir_fecha($request->licitacion),
      ]);
      return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');
    }

    public function ulimitesproyecto(Request $request,$id)
    {
        $configuracion = Configuracion::find($id);
        $configuracion->libre_gestion = $request->libre_gestion;
        $configuracion->licitacion = $request->licitacion;
        $configuracion->save();
      return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');
    }


    protected function validar_alcaldia(array $data)
    {
        return Validator::make($data, [
            'direccion_alcaldia' => 'required',
            'telefono_alcaldia' => 'required',
            'fax_alcaldia' => 'required',
            'email_alcaldia' => 'required|email',
            'nit_alcaldia' => 'required',
        ]);
    }

    protected function validar_alcalde(array $data)
    {
        return Validator::make($data, [
            'nombre_alcalde' => 'required',
            'oficio_alcalde' => 'required',
            'dui_alcalde' => 'required',
            'nit_alcalde' => 'required|email',
            'domicilio_alcalde' => 'required',
            'nacimiento_alcalde' => 'required|date',
        ]);
    }

}
