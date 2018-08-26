<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategoriaTrabajo;
use App\Bitacora;

class CategoriaTrabajoController extends Controller
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
        $categoriatrabajos = CategoriaTrabajo::all();
        return view('categoriatrabajos.index', compact('categoriatrabajos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoriatrabajos = CategoriaTrabajo::all();
        return view('categoriatrabajos.create', compact('categoriatrabajos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CategoriaTrabajo::create($request->All());
        return redirect('categoriatrabajos')->with('mensaje','Categoría registrada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoriatrabajo = CategoriaTrabajo::findorFail($id);
        return view('categoriatrabajos.show', compact('categoriatrabajo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoriatrabajo = CategoriaTrabajo::findorFail($id);
        return view('categoriatrabajos.edit', compact('categoriatrabajo'));
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
