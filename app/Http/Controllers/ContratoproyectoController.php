<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContratoProyecto;
use App\Empleado;
use App\Proyecto;
use App\Cargo;
use App\Http\Requests\ContratoRequest;
use App\Http\Requests\EmpleadoRequest;
use App\Http\Requests\ContratoproyectoRequest;
use App\Http\Requests\CargoRequest;
use Storage;
use DB;

class ContratoproyectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function bajar($file_name)
    {
        $file = '/proyectos/contratos/' . $file_name;
      //dd($file);
      $disk = Storage::disk('local');
      if ($disk->exists($file)) {
          $fs = Storage::disk('local')->getDriver();
          $stream = $fs->readStream($file);
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
}
