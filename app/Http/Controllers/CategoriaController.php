<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Bitacora;
use App\Http\Requests\CategoriaRequest;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index',compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$categorias = Categoria::all();
        return view('categorias.create',compact('categorias'));*/
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaRequest $request)
    {
        if($request->Ajax())
        {
          try{
              $categoria = Categoria::create($request->All());
              return response()->json([
                  'mensaje' => 'exito',
                  'data' => $categoria
              ]);
          }catch(\Exception $e){
              return response()->json([
                  'mensaje' => 'error'
              ]);
          }
        }else{
          Categoria::create($request->All());
          return redirect('categorias')->with('mensaje','Categoría registrada');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::find($id);

        return array(1,"exitoso",$categoria);
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
        $categoria = Categoria::find($id);
        if($categoria->nombre_categoria != $request->nombre_categoria){
            $this->validate($request,['nombre_categoria'=> 'required|unique:categorias|min:5']);
        }

        $categoria->nombre_categoria = $request->nombre_categoria;
        $categoria->save();

        return array(1,"éxito");
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

    public function baja(request $request, $id)
    {
        $categoria = Categoria::find($id);
        $categoria->estado = 2;
        $categoria->motivo = $request->motivo;
        $categoria->fechabaja = date('Y-m-d');
        $categoria->save();
        bitacora('Dió de baja categoría');
        return array(1);
    }

    public function alta($id)
    {
        $categoria = Categoria::find($id);
        $categoria->estado = 1;
        $categoria->motivo = null;
        $categoria->fechabaja = null;
        $categoria->save();
        Bitacora::bitacora('Dió de alta una categoría');
        return array(1);
    }
}
