<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Storage;
use Log;
use Carbon\Carbon;

class BackupController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

    
  public function index()
  {
    $disco = Storage::disk('local');
    $archivos = $disco->files('\backups');
    $respaldos = [];
    foreach ($archivos as $k => $f) {
    if ($disco->exists($f)) {
              $respaldos[] = [
                  'directorio' => $f,
                  'nombre' => str_replace('backups'. '/', '', $f),
                  'tamanio' => $disco->size($f),
                  'fecha' => $disco->lastModified($f),
              ];
            }
          }
        //  dd($respaldos);
      return view("respaldos.index",compact('respaldos'));
    }

  public function create()
  {
    $string="respaldo_".Carbon::now()->format('d-m-y_h_i_s_a').".sql";
    try {
        // start the backup process
        Artisan::call("db:backup", [
          "--database" => "mysql", // This missed
          "--destination" => "local",
          "--destinationPath" => "/".$string,
          "--compression" => "null",
        ]);
        $output = Artisan::output();
        // log the results
        Log::info("Se inició un respaldo desde la aplicación \r\n" . $output);
        Log::info("Respaldo completado con exito");
        bitacora("Se creó un nuevo respaldo de la base de datos");
        // return the results as a response to the ajax call
        return array(1,"exito");
    } catch (Exception $e) {
        //Flash::error($e->getMessage());
        return array(-1,"error",$e->getMessage());
    }
  }

  public function descargar($file_name)
  {
    $file = 'backups/' . $file_name;
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
        abort(404, "The backup file doesn't exist.");
    }
  }

  public function restaurar($file_name)
  {
    set_time_limit(300);
    $respaldo = $file_name;
    try {
        // start the backup process
        Artisan::call("db:restore", [
          "--source" => "local",
          "--sourcePath" => "/".$respaldo,
          "--database" => "mysql", // This missed
          "--compression" => "null",
        ]);
        $output = Artisan::output();
        // log the results
        Log::info("Se inició una restauración desde la aplicación \r\n" . $output);
        Log::info("Restauración completado con exito");
        bitacora("Se restuaró el respaldo '".$respaldo."' con éxito");
        // return the results as a response to the ajax call
        return array(1,"exito");
    } catch (Exception $e) {
      return array(-1,"error",$e->getMessage());
    }
  }

  public function eliminar($file_name)
  {
    //dd($file_name);
    $disk = Storage::disk('local');
    if ($disk->exists('backups/' . $file_name)) {
        $disk->delete('backups/' . $file_name);
        bitacora("El respaldo '".$file_name."' se eliminó con éxito de la base de datos");
        return array(1,"exito");
    } else {
        return array(-1,"error");
    }
  }
}
