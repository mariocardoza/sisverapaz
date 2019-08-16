<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Redirect;

class ContratoRequisicionController extends Controller
{
    public function bajar($file_name)
    {
        $file = '/requisiciones/contratos/' . $file_name;
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
