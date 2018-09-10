<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuracion;

class ConfiguracionController extends Controller
{
    public function create()
    {
      $configuraciones = Configuracion::first();

      return view('configuraciones.create',compact('configuraciones'));
    }

    public function alcaldia(Request $request)
    {
      Configuracion::create([
        "direccion_alcaldia" => $request->direccion_alcaldia,
        "nit_alcaldia" => $request->nit_alcaldia,
        "telefono_alcaldia" => $request->telefono_alcaldia,
        "fax_alcaldia" => $request->fax_alcaldia,
        "email_alcaldia" => $request->email_alcaldia
      ]);
      return redirect('configuraciones')->with('mensaje','Datos registrados con éxito');
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

    public function logo(Request $request)
    {

    }
}
