<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipocontratoRequest;
use Illuminate\Http\Request;
use App\Tiposervicio;
use App\Http\Requests\TiposervicioRequest;

class TipoServicioController extends Controller
{
    public function index()
    {
        $servicios=TipoServicio::select('id', 'nombre', 'costo', 'estado', 'isObligatorio')->get();
        $html='';
      foreach($servicios as $i => $r){
        $html.='<tr>
          <td>'.($i+1).'</td>
          <td><span class="spanver'.$i.'">'.$r->nombre.'</span><input style="display:none;" class="form-control nombre_ser'.$i.' spannover'.$i.'" type="text" value="'.$r->nombre.'"></td>
          <td><span class="spanver'.$i.'">$'.number_format($r->costo,2).'</span><input style="display:none;" class="form-control costo_ser'.$i.' spannover'.$i.'" type="text" value="'.$r->costo.'"></td>
          <td>';
          if($r->isObligatorio==1):
            $html.='<span class="spanver'.$i.' label label-primary">Fijo</span>';
          else:
            $html.='<span class="spanver'.$i.' label label-primary">Variable</span>';
          endif;
          $html.='</td>
          <td>';
          if($r->estado==1):
            $html.='<span class="spanver'.$i.' label label-success">Activo</span>';
          else:
            $html.='<span class="spanver'.$i.' label label-danger">Inactivo</span>';
          endif;
          $html.='</td>
          <td>
            <div class="btn-group">';
            if($r->estado==1):
              $html.='<button type="button" data-fila="'.$i.'" data-id="'.$r->id.'" id="editar_s" class="ocu btn btn-warning spanver'.$i.'">
              <i class="fa fa-pencil"></i>
            </button><button type="button" data-id="'.$r->id.'" id="quitar_s" class="ocu btn btn-danger spanver'.$i.'">
                <i class="fa fa-minus-circle"></i>
              </button><button type="button" data-fila="'.$i.'" data-id="'.$r->id.'" id="editar_ser" style="display:none" class="btn btn-success spannover'.$i.'">
              <i class="fa fa-check"></i>
            </button><button type="button" data-fila="'.$i.'" data-id="'.$r->id.'" id="can_edit" style="display:none" class="btn btn-danger spannover'.$i.'">
            <i class="fa fa-minus-circle"></i>
          </button>';
            else:
              $html.='<button data-id="'.$r->id.'" type="button" id="restaurar_s" class="btn btn-success">
                <i class="fa fa-plus-circle"></i>
              </button>';
            endif;
            $html.='</div>
          </td>
        </tr>';
      }
      return array(1,"exito",$html);
    }

    public function show(TipoServicio $tipoServicio)
    {
        return $tipoServicio;
    }

    /* Nuevo Servicio */
    public function store(TiposervicioRequest $request)
    {
      $tipo  = new Tiposervicio();
      $params = $request->all();

      $tipo->estado = 1;
      $tipo->nombre = $params['nombre'];
      $tipo->costo  = $params['costo'];
      $tipo->isObligatorio = $params['isObligatorio'];

      if($tipo->save()){
        return array(
          "response"  => true,
          "data"      => $tipo,
          "message"   => 'Hemos agregado con exito al nuevo servicio',
        );
      }else{
        return array(
          "response"  => false,
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
        );
      }
    }

    /* Editar Servicio */
    public function update(TiposervicioRequest $request, $id)
    {
      $params = $request->all();
      $tipo = Tiposervicio::find($id);

      $tipo->nombre   = $params['nombre'];
      $tipo->costo    = $params['costo'];
      
      if($tipo->save()) {
        return array(
          "message"   => 'Hemos actualizado con exito la informacion',
          "data"      => Tiposervicio::find($id),
          "ok"        => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }

    public function destroy($id, Request $request)
    {
      $params = $request->all();
      $tipo = Tiposervicio::find($id);
      $tipo->estado = $params['estado'] == 'true' ? 1 : 0;
      
      if($tipo->save()) {
        return array(
          "message"         => 'Hemos actualizado con exito el estado',
          "ok"  => true
        );
      }else{
        return array(
          "message"         => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }
}

