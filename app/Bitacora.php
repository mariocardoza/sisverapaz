<?php

namespace App;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Events\BitacoraSaved;
use Illuminate\Http\Request;

class Bitacora extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at'];

    protected $events = [
        'saved'=>BitacoraSaved::class,
    ];

    public static function bitacora($accion,$table='')
    {
      $log = [];
      $log['tabla'] = $table==''? '-':$table;
      $log['accion'] = $accion;
      $log['url'] = Request()->fullUrl();
      $log['method'] = Request()->method();
      $log['ip'] = Request()->ip();
      $log['agent'] = Request()->header('user-agent');
      $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
      Bitacora::create($log);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function pordia($dia)
    {
        $html="";
        $bitacoras=Bitacora::where('created_at',$dia)->orderby('created_at','DESC')->orderby('created_at','DESC')->get();
        $html.='<table class="table table-hover" id="bitaco">
        <thead>
         <th>N°</th>
         <th>Fecha</th>
         <th>Hora</th>
         <th>Acción</th>
         <th>Ip</th>
          <th>URL</th>
          <th>Tabla</th>
          <th>Navegador</th>
         <th>Usuario</th>
       </thead>
       <tbody id="bita">';
         foreach($bitacoras as $key => $bitacora):
         $html.='<tr>
           <td>'.($key+1).'</td>
           <td>'.fechaCastellano($bitacora->created_at).'</td>
           <td>'.$bitacora->created_at->format('H:i:s').'</td>
           <td>'.$bitacora->accion.'</td>
           <td>'.$bitacora->ip.'</td>
           <td>'.$bitacora->url.'</td>
           <td>'.$bitacora->tabla.'</td>
           <td>'.get_browser_name($bitacora->agent).'</td>
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
        $bitacoras=Bitacora::where('user_id',$usuario)->orderby('created_at','DESC')->orderby('created_at','DESC')->get();
        $html.='<table class="table table-hover" id="bitaco">
        <thead>
         <th>N°</th>
         <th>Fecha</th>
         <th>Hora</th>
         <th>Acción</th>
         <th>Ip</th>
          <th>URL</th>
          <th>Tabla</th>
          <th>Navegador</th>
         <th>Usuario</th>
       </thead>
       <tbody id="bita">';
         foreach($bitacoras as $key => $bitacora):
         $html.='<tr>
           <td>'.($key+1).'</td>
           <td>'.fechaCastellano($bitacora->created_at).'</td>
           <td>'.$bitacora->created_at->format('H:i:s').'</td>
           <td>'.$bitacora->accion.'</td>
           <td>'.$bitacora->ip.'</td>
           <td>'.$bitacora->url.'</td>
           <td>'.$bitacora->tabla.'</td>
           <td>'.get_browser_name($bitacora->agent).'</td>
           <td>'.$bitacora->user->empleado->nombre.'</td>
           
         </tr>';
         endforeach;
       $html.='</tbody>
     </table>';

     return array(1,"exito",$html,$bitacoras);
    }

    public static function porperiodo($inicio,$fin)
    {
        $html="";
        $bitacoras=Bitacora::where('created_at','>=',$inicio)->where('created_at','<=',$fin)->orderby('created_at','DESC')
        ->orderby('hora','DESC')->get();
        $html.='<table class="table table-hover" id="bitaco">
        <thead>
         <th>N°</th>
         <th>Fecha</th>
         <th>Hora</th>
         <th>Acción</th>
         <th>Ip</th>
          <th>URL</th>
          <th>Tabla</th>
          <th>Navegador</th>
         <th>Usuario</th>
       </thead>
       <tbody id="bita">';
         foreach($bitacoras as $key => $bitacora):
         $html.='<tr>
           <td>'.($key+1).'</td>
           <td>'.fechaCastellano($bitacora->created_at).'</td>
           <td>'.$bitacora->created_at->format('H:i:s').'</td>
           <td>'.$bitacora->accion.'</td>
           <td>'.$bitacora->ip.'</td>
           <td>'.$bitacora->url.'</td>
           <td>'.$bitacora->tabla.'</td>
           <td>'.get_browser_name($bitacora->agent).'</td>
           <td>'.$bitacora->user->empleado->nombre.'</td>
           
         </tr>';
         endforeach;
       $html.='</tbody>
     </table>';

     return array(1,"exito",$html);
    }
}
