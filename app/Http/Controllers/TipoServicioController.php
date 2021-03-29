<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipocontratoRequest;
use Illuminate\Http\Request;
use App\Tiposervicio;
use App\Http\Requests\TiposervicioRequest;
use Validator;

class TipoServicioController extends Controller
{
    public function index(Request $request)
    {
      if($request->ajax()):
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
      return array(1,"éxito",$html);
    else:
      $estado = $request->estado==2 ? 2 : 1;
      $tipoServicios = TipoServicio::whereEstado($estado)->get();
      return view('tiposervicios.index',compact('tipoServicios'));
    endif;
    }

    public function create()
    {
      return view('tipoServicios.create');
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
          "message"   => 'Hemos agregado con éxito al nuevo servicio',
        );
      }else{
        return array(
          "response"  => false,
          "message"   => 'Tenemos problema con el servidor por le momento. Intenta más tarde'
        );
      }
    }

    protected function validar(array $data)
    {
      return Validator::make($data, [
        'nombre' => 'required|unique:tiposervicios',
      ]);
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
          "message"   => 'Hemos actualizado con éxito la información',
          "data"      => Tiposervicio::find($id),
          "ok"        => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. Intenta más tarde',
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
          "message"         => 'Hemos actualizado con éxito el estado',
          "ok"  => true
        );
      }else{
        return array(
          "message"         => 'Tenemos problema con el servidor por le momento. Intenta más tarde',
          "ok"  => false
        );
      }
    }

    public function baja($cadena)
    {
      $datos = explode("+", $cadena);
      $id = $datos[0];
      $motivo = $datos[1];
      $tiposervicio = TipoServicio::find($id);
      $tiposervicio->estado = 2;
      $tiposervicio->motivo = $motivo;
      $tiposervicio->fechabaja = date('Y-m-d');
      $tiposervicio->save();
      bitacora('Registro dado de baja');
      return redirect('/tiposervicios')->with('mensaje','Registro dado de baja');
    }

    public function alta($id)
    {
      $tiposervicio = TipoServicio::find($id);
      $tiposervicio->estado = 1;
      $tiposervicio->motivo = null;
      $tiposervicio->fechabaja = null;
      $tiposervicio->save();
      bitacora('Registro dado de alta');
      return redirect('/tiposervicios')->with('mensaje','Registro dado de alta');
    }
}

