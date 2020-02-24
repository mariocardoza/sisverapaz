<?php

namespace App;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Events\BitacoraSaved;

class Bitacora extends Model
{
    protected $guarded = [];
    protected $dates = ['registro'];

    protected $events = [
        'saved'=>BitacoraSaved::class,
    ];

    public static function bitacora($accion)
    {
        $bitacora = new Bitacora;
        $bitacora->registro = date('Y-m-d');
        $bitacora->hora = date('H:i:s');
        $bitacora->accion = $accion;
        $bitacora->user_id = Auth()->user()->id;
        $bitacora->save();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function pordia($dia)
    {
        $html="";
        $bitacoras=Bitacora::where('registro',$dia)->get();
        $html.='<table class="table table-hover" id="bitaco">
        <thead>
         <th>N°</th>
         <th>Fecha de actividad</th>
         <th>Hora de la actividad</th>
         <th>Acción</th>
         <th>Usuario</th>
       </thead>
       <tbody id="bita">';
         foreach($bitacoras as $key => $bitacora):
         $html.='<tr>
           <td>'.($key+1).'</td>
           <td>'.fechaCastellano($bitacora->registro).'</td>
           <td>'.$bitacora->hora.'</td>
           <td>'.$bitacora->accion.'</td>
           <td>'.$bitacora->user->empleado->nombre.'</td>
           
         </tr>';
         endforeach;
       $html.='</tbody>
     </table>';

     return array(1,"exito",$html);
    }

    public static function porempleado($usuario)
    {
        $html="";
        $bitacoras=Bitacora::where('user_id',$usuario)->get();
        $html.='<table class="table table-hover" id="bitaco">
        <thead>
         <th>N°</th>
         <th>Fecha de actividad</th>
         <th>Hora de la actividad</th>
         <th>Acción</th>
         <th>Usuario</th>
       </thead>
       <tbody id="bita">';
         foreach($bitacoras as $key => $bitacora):
         $html.='<tr>
           <td>'.($key+1).'</td>
           <td>'.fechaCastellano($bitacora->registro).'</td>
           <td>'.$bitacora->hora.'</td>
           <td>'.$bitacora->accion.'</td>
           <td>'.$bitacora->user->empleado->nombre.'</td>
           
         </tr>';
         endforeach;
       $html.='</tbody>
     </table>';

     return array(1,"exito",$html);
    }

    public static function porperiodo($inicio,$fin)
    {
        $html="";
        $bitacoras=Bitacora::where('registro','>=',$inicio)->where('registro','<=',$fin)->get();
        $html.='<table class="table table-hover" id="bitaco">
        <thead>
         <th>N°</th>
         <th>Fecha de actividad</th>
         <th>Hora de la actividad</th>
         <th>Acción</th>
         <th>Usuario</th>
       </thead>
       <tbody id="bita">';
         foreach($bitacoras as $key => $bitacora):
         $html.='<tr>
           <td>'.($key+1).'</td>
           <td>'.fechaCastellano($bitacora->registro).'</td>
           <td>'.$bitacora->hora.'</td>
           <td>'.$bitacora->accion.'</td>
           <td>'.$bitacora->user->empleado->nombre.'</td>
           
         </tr>';
         endforeach;
       $html.='</tbody>
     </table>';

     return array(1,"exito",$html);
    }
}
