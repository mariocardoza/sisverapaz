<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PresupuestoRequest;
use App\Http\Requests\CatalogoRequest;
use App\Http\Requests\CategoriaRequest;
use App\Proyecto;
use App\Presupuesto;
use App\Presupuestodetalle;
use App\Categoria;
use App\Catalogo;
use App\Materiales;
use App\BitacoraProyecto;
use Session;
use DB;
use Validator;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
     {
         $this->middleware('auth');
         //Session::forget('presupuestos');
     }

    

    public function index(Request $request)
    {
      $proyecto=$request->get('proyecto');
      if($proyecto=="")
      {
        $existe=true;
        $presupuestos = Presupuesto::all();
        return view('presupuestos.index',compact('presupuestos','existe'));
      }else{
        $presupuestos = Presupuesto::where('proyecto_id',$proyecto)->get();
        $count = count($presupuestos);
        if($count==0){
          $existe=false;
          return view('presupuestos.index',compact('presupuestos','existe','proyecto'));
        }else{
          $existe=true;
          return view('presupuestos.index',compact('presupuestos','existe','proyecto'));
        }

      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //$query = 'select proyectos."id",proyectos.nombre from proyectos inner join presupuestos on proyectos."id"=presupuestos."id"';
      //$proyectos = \DB::select(\DB::raw($query));

      //$proyectos=DB::select('SELECT "id" FROM proyectos WHERE estado =1 EXCEPT SELECT proyecto_id FROM presupuestos');
        $proyectos = Proyecto::where('estado',1)->where('pre',false)->get();
        $categorias = Categoria::all();
       return view('presupuestos.create',compact('proyectos','categorias'));
    }

    public function cambiar(Request $request)
    {
        if($request->ajax()){
            try{
                $proyecto=Proyecto::findorFail($request->id);
                $proyecto->estado=3;
                $proyecto->save();

                BitacoraProyecto::bitacora('El proyecto pasó a esperar la realización de la solicitud de cotizacion',$proyecto->id);

                return response()->json([
                    'mensaje' => 'exito'
                ]);
            }catch(\Exception $e){
                return response()->json([
                'mensaje' => 'error'
                ]);
            }

        }
    }

    public function getCategorias($id)
    {
      return $categorias = DB::table('categorias')
                ->whereNotExists(function ($query) use ($id) {
                     $query->from('presupuestos')
                        ->whereRaw('presupuestos.categoria_id = categorias.id')
                        ->whereRaw('presupuestos.proyecto_id ='.$id);
                    })->get();
    }

    public function getCatalogo($id,$idd)
    {
        //return Materiales::where('categoria_id',$id)->orderby('nombre','asc')->get();
        return DB::table('materiales')
        ->select('materiales.id','materiales.nombre')
        ->where('materiales.estado',1)
        ->where('materiales.categoria_id',$id)
        ->whereNotExists(function ($query) use ($idd)  {
          $query->from('presupuestodetalles')
          ->whereRaw('presupuestodetalles.material_id = materiales.id')
          ->whereRaw('presupuestodetalles.presupuesto_id ='.$idd);
        })
        ->orderby('materiales.nombre')
        ->get();
    }

    public function getUnidadesMedida()
    {
      return \App\UnidadMedida::orderBy('nombre_medida')->get();
    }

    public function seleccionaritem($id)
    {
      $proyecto = Proyecto::findorFail($id);
      //dd($proyecto);
      return view('presupuestos.seleccionaritem',compact('proyecto'));
    }

    public function crear(Request $request)
    {
    //  dd($request->All());
      $proyecto = Proyecto::findorFail($request->proyecto_id);
      $item1=Categoria::findorFail($request->item);

      $items=Categoria::all();
      return view('presupuestos.create',compact('proyecto','items','item1'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresupuestoRequest $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try{
                $presupuestos = $request->presupuestos;

                $presupuesto = Presupuesto::create([
                    'proyecto_id' => $request->proyecto_id,
                    'total' => $request->total,
                ]);

                  foreach($presupuestos as $presu){
                    Presupuestodetalle::create([
                      'presupuesto_id' => $presupuesto->id,
                      'cantidad' => $presu['cantidad'],
                      'preciou' => $presu['precio'],
                      'material_id' => $presu['material'],
                      'unidad_medida'=>$presu['medida'],
                    ]);
                  }
                  $proyecto = Proyecto::findorFail($request->proyecto_id);
                  $proyecto->pre=true;
                  $proyecto->estado=2;
                  $proyecto->save();

                  BitacoraProyecto::bitacora('Registro el presupuesto de '.$presupuesto->proyecto->nombre,$proyecto->id);
                  DB::commit();
                  return array(1,"exito");
            }catch (\Exception $e){
                DB::rollback();
                return array(-1,"error",$e);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presupuesto = Presupuesto::findorFail($id);
        return view('presupuestos.show',compact('presupuesto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try{
          $presupuestos = $request->presupuestos;
          $presupuesto=Presupuesto::find($id);
          foreach($presupuestos as $presu){
            Presupuestodetalle::create([
              'presupuesto_id' => $presupuesto->id,
              'cantidad' => $presu['cantidad'],
              'preciou' => $presu['precio'],
              'material_id' => $presu['material'],
              'unidad_medida'=>$presu['medida'],
            ]);
          }
          return array(1,"exito",$presupuesto);
        }catch(Exception $e){
          return array(-1,"error",$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
