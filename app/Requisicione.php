<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Requisicione extends Model
{
  protected $fillable = ['id','codigo_requisicion','actividad','user_id','observaciones','fondocat_id','unidad_id'];
  protected $primaryKey = "id";
  public $incrementing = false;

  public static function correlativo()
  {
    $numero=Requisicione::where('created_at','>=',date('Y'.'-1-1'))->where('created_at','<=',date('Y'.'-12-31'))->count();
    if($numero>0 && $numero<10){
      return "RQ-00".($numero+1)."-".date("Y");
    }else{
      if($numero >= 10 && $numero <100){
        return "RQ-0".($numero+1)."-".date("Y");
      }else{
        if($numero>=100){
          return "RQ-".($numero+1)."-".date("Y");
        }else{
          return "RQ-001-".date("Y");
        }
      }
    }
  }

  public static function estado_ver($id){
    $requisicion=Requisicione::find($id);
    $html="";
    switch ($requisicion->estado) {
      case 1:
        $html.='<span class="col-xs-12 label-primary">En espera</span>';
        break;
      case 2:
        $html.='<span class="col-xs-12 label-danger">Rechazado</span>';
        break;
      case 3:
        $html.='<span class="col-xs-12 label-info">Aceptada y recibiendo cotizaciones</span>';
        break;
      case 4:
        $html.='<span class="col-xs-12 label-info">Pendiente de realizar orden de compra</span>';
        break;
      case 5:
        $html.='<span class="col-xs-12 label-warning"><strong>Pendiente de recibir insumos</strong></span>';
        break;
      case 6:
        $html.='<span class="col-xs-12 label-success"><strong>Insumos recibidos</strong></span>';
        break;
      case 7:
        $html.='<span class="col-xs-12 label-success"><strong>Proceso finalizado</strong></span>';
        break;
      default:
        $html.='<span class="col-xs-12 label-success">Default</span>';
        break;
    }

    return $html;
  }

  public function unidad()
  {
    return $this->belongsTo('App\Unidad');
  }

  public function requisiciondetalle()
  {
    return $this->hasMany('App\Requisiciondetalle','requisicion_id');
  }

  public function solicitudcotizacion()
  {
    return $this->hasMany('App\Solicitudcotizacion','requisicion_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function fondocat()
  {
    return $this->belongsTo('App\Fondocat');
  }

  public static function tiene_materiales($id){
    $retorno=false;
    $detas=Requisiciondetalle::where('requisicion_id',$id)->get();
    foreach($detas as $deta){
      if($deta['estado']==1){
        $retorno=true;
      }
    }
    return $retorno;
  }

  public static function materiales($id){
    $materiales = DB::table('materiales as m')
                  ->select('m.*','c.nombre_categoria','u.id as elid','u.nombre_medida')
                  ->join('categorias as c','m.categoria_id','=','c.id')
                  ->join('unidad_medidas as u','m.unidad_id','=','u.id')
                    ->whereNotExists(function ($query) use ($id)  {
                         $query->from('requisiciondetalles')
                            ->whereRaw('requisiciondetalles.materiale_id = m.id')
                            ->whereRaw('requisiciondetalles.requisicion_id ='.$id);
                        })->get();
    //$materiales=Materiales::where('estado',1)->get();
    $tabla='';
    foreach ($materiales as $key => $material) {
      $tabla.='<tr>
                <td>'.($key+1).'</td>
                <td>'.$material->nombre.'</td>
                <td>'.$material->nombre_categoria.'</td>
                <td>'.$material->nombre_medida.'</td>
                <td><input type="number" class="form-control canti"></td>
                <td><button type="button" data-unidad="'.$material->elid.'" data-material="'.$material->id.'" class="btn btn-primary btn-sm" id="esteagrega"><i class="fa fa-check"></i></button></td>
              </tr>';
    }

    return array(1,"exito",$tabla,$materiales);
  }
}
