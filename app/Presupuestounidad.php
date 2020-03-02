<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Presupuestounidad extends Model
{
    protected $guarded =[];

    public function unidad()
    {
    	return $this->belongsTo('App\Unidad');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function presupuestodetalle()
    {
        return $this->hasMany('App\Presupuestounidaddetalle');
    }

    public static function estado_ver($id)
    {
      $presupuesto=Presupuestounidad::find($id);
      $html="";
      switch ($presupuesto->estado) {
        case 1:
          $html.='<span class="col-xs-12 label-primary text-center">En espera</span>';
          break;
        case 2:
          $html.='<span class="col-xs-12 label-danger text-center">Rechazado</span>';
          break;
        case 3:
          $html.='<span class="col-xs-12 label-success text-center">Aprobado</span>';
          break;
        case 4:
          $html.='<span class="col-xs-12 label-success text-center">Completado</span>';
          break;
        default:
          $html.='<span class="col-xs-12 label-success">Default</span>';
          break;
      }
      return $html;
    }

    public static function materiales($id){
      $presu=Presupuestounidad::find($id);
        $materiales = DB::table('materiales as m')
                      ->select('m.*','c.nombre_categoria','u.id as elid','u.nombre_medida')
                      ->join('categorias as c','m.categoria_id','=','c.id')
                      ->join('unidad_medidas as u','m.unidad_id','=','u.id')
                        ->whereNotExists(function ($query) use ($id)  {
                             $query->from('presupuestounidaddetalles')
                                ->whereRaw('presupuestounidaddetalles.material_id = m.id')
                                ->whereRaw('presupuestounidaddetalles.presupuestounidad_id ='.$id);
                            })->get();
        //$materiales=Materiales::where('estado',1)->get();
       
        $tabla='';
        foreach ($materiales as $key => $material) {
          $tabla.='<tr>
                    <td>'.($key+1).'</td>
                    <td>'.$material->nombre.'</td>
                    <td>'.$material->nombre_categoria.'</td>
                    <td>'.$material->nombre_medida.'</td>
                    <td><button type="button" data-unidad="'.$material->elid.'" data-nombre="'.$material->nombre.'" data-material="'.$material->id.'" class="btn btn-primary btn-sm" id="esteagrega"><i class="fa fa-check"></i></button></td>
                  </tr>';
        }
    
        return array(1,"exito",$tabla,$materiales);
      }

      public static function total_presupuesto($id){
        $presupuesto=Presupuestounidad::find($id);
        $total=0.0;
        foreach($presupuesto->presupuestodetalle as $deta){
          $total=$total+($deta->precio*$deta->cantidad);
        }

        return $total;
      }
}
