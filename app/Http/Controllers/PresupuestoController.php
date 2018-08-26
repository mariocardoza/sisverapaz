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

    public function getCatalogo($id)
    {
        return Catalogo::where('categoria_id',$id)->orderby('nombre','asc')->get();
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
                    'categoria_id' => $request->categoria_id,
                ]);

                  foreach($presupuestos as $presu){
                    Presupuestodetalle::create([
                      'presupuesto_id' => $presupuesto->id,
                      'cantidad' => $presu['cantidad'],
                      'preciou' => $presu['precio'],
                      'catalogo_id' => $presu['catalogo'],
                    ]);
                  }
                  $proyecto = Proyecto::findorFail($request->proyecto_id);
                  $proyecto->pre=true;
                  $proyecto->estado=2;
                  $proyecto->save();

                  BitacoraProyecto::bitacora('Registro el presupuesto de '.$presupuesto->categoria->nombre_categoria.' ',$proyecto->id);
                  DB::commit();
                  return response()->json([
                    'mensaje' => 'exito'
                  ]);
            }catch (\Exception $e){
                DB::rollback();
                return response()->json([
                    'mensaje' => 'error',
                    'tipo' =>$e->getMessage()
                  ]);
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
        //
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
