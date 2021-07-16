<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rubro;
use App\Bitacora;
use App\Http\Requests\RubroRequest;
use App\Carbon;
use App\CategoriaRubro;

class RubroController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      if($request->ajax()){
        $rubros=Rubro::all();
        $categorias=CategoriaRubro::all();
        $html='';
        foreach($rubros as $i => $r){
          $html.='<tr>
            <td>'.($i+1).'</td>
            <td><span class="visible'.$i.'">'.$r->categoriarubro->nombre.'</span>
              <select class="form-control invisible'.$i.' cate'.$i.'" style="display:none";>
                ';
                foreach($categorias as $categoria){
                  $html.='<option value="'.$categoria->id.'" >'.$categoria->nombre.'</option>';
                }
            $html.='</select></td>
            <td><span class="visible'.$i.'">'.$r->nombre.'</span><input class="form-control invisible'.$i.' nonr'.$i.'" type="text" value="'.$r->nombre.'" style="display:none";></td>
            <td><span class="visible'.$i.'">'.number_format($r->porcentaje*100,2).'%</span><input class="form-control invisible'.$i.' porcen'.$i.'" type="text" value="'.($r->porcentaje*100).'" style="display:none";></td>
            <td>';
            if($r->es_formula==1):
              $html.='<span class="visible'.$i.' label label-info">Si</span>';
            else:
              $html.='<span class="visible'.$i.' label label-info">No</span>';
            endif;
            $html.='<select class="form-control invisible'.$i.' formu'.$i.'" style="display:none";>
              <option value="0">No</option>
              <option value="1">Si</option>
            </select>';
            $html.='</td>
            <td>';
            if($r->estado==1):
              $html.='<span class="label label-success">Activo</span>';
            else:
              $html.='<span class="label label-danger">Inactivo</span>';
            endif;
            $html.='</td>
            <td>
              <div class="btn-group">';
              if($r->estado==1):
                $html.='<button type="button" data-id="'.$r->id.'" data-fila="'.$i.'" id="editar_r" class="btn btn-warning ocu visible'.$i.'">
                <i class="fa fa-pencil"></i>
              </button><button type="button" data-id="'.$r->id.'" id="quitar_r" class="btn btn-danger ocu visible'.$i.'">
                  <i class="fa fa-minus-circle"></i>
                </button>
                <button style="display:none;" type="button" data-id="'.$r->id.'" data-fila="'.$i.'" id="eleditar_r" class="btn btn-success invisible'.$i.'">
                  <i class="fa fa-check"></i>
                </button>
                <button style="display:none;" type="button" data-id="'.$r->id.'" data-fila="'.$i.'" id="can_edit_r" class="btn btn-danger invisible'.$i.'">
                  <i class="fa fa-minus-circle"></i>
                </button>';
              else:
                $html.='<button data-id="'.$r->id.'" type="button" id="restaurar_r" class="btn btn-success ocu visible'.$i.'">
                  <i class="fa fa-plus-circle"></i>
                </button>';
              endif;
              $html.='</div>
            </td>
          </tr>';
        }

        return array(1,"exito",$html);
      }else{
        $rubros = Rubro::all();
        return view('rubros.index',compact('rubros'));
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rubros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RubroRequest $request)
    {
      $rubro  = new Rubro();
      $params = $request->all();

      $rubro->estado = 1;
      $rubro->nombre = $params['nombre'];
      $rubro->es_formula = $params['formula'];
      $rubro->categoriarubro_id = $params['categoriarubro'];
      $rubro->porcentaje = $params['porcentaje']/100;

      if($rubro->save()){
        return array(
          "response"  => true,
          "data"      => $rubro,
          "message"   => 'Hemos agregado con exito al nuevo rubro',
        );
      }else{
        return array(
          "response"  => false,
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
        );
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rubro $rubro)
    {
        //$rubro = Rubro::findorFail($id);
        return view('rubros.edit',compact('rubro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
      $params = $request->all();
      $rubro = Rubro::find($id);
      $rubro->nombre      = $params['nombre'];
      $rubro->categoriarubro_id   = $params['categoria'];
      $rubro->es_formula = $params['formula'];
      $rubro->porcentaje  = $params['porcentaje']/100;
      
      if($rubro->save()) {
        return array(
          "message"   => 'Hemos actualizado con exito la informacion',
          "data"      => Rubro::find($id),
          "ok"        => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
      $params = $request->all();
      $rubro = Rubro::find($id);
      $negocios = $rubro->negocios_activos;
      if($negocios->count() > 0){
        return array(
          "message"   => 'Este rubro esta asignado a negocios activos, por favor verificar.',
          "ok"  => false
        );
      }
      $rubro->estado = $params['estado'] == 'true' ? 1 : 0;
      
      if($rubro->save()) {
        return array(
          "message"   => 'Hemos actualizado con exito el estado',
          "ok"  => true
        );
      }else{
        return array(
          "message"   => 'Tenemos problema con el servidor por el momento. intenta mas tarde',
          "ok"  => false
        );
      }
    }

    public function baja($cadena)
    {

        $datos = explode("+", $cadena);
        $id=$datos[0];
        $motivo=$datos[1];
        //dd($id);
        $rubro = Rubro::find($id);
        $rubro->estado=2;
        $rubro->motivo=$motivo;
        $rubro->fechabaja=date('Y-m-d');
        $rubro->save();
        bitacora('Dió de baja a un rubro');
        return redirect('/rubros')->with('mensaje','Rubro dado de baja');
    }

    public function alta($id)
    {

        //$datos = explode("+", $cadena);
        ////$id=$datos[0];
        //$motivo=$datos[1];
        //dd($id);
        $rubro = Rubro::find($id);
        $rubro->estado=1;
        $rubro->motivo=null;
        $rubro->fechabaja=null;
        $rubro->save();
        Bitacora::bitacora('Dió de alta a un rubro');
        return redirect('/rubros')->with('mensaje','Proyecto dado de alta');
    }

    public function GetApiController () {
        return Rubro::all();
    }
}