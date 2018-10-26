<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipocontratoRequest;
use Illuminate\Http\Request;
use App\Tiposervicio;
use App\Http\Requests\TiposervicioRequest;
class TiposervicioController extends Controller
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

    public function index()
    {
        $tiposervicios = Tiposervicio::all();
        return view('tiposervicios.index',compact('tiposervicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tiposervicios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TiposervicioRequest $request)
    {
        Tiposervicio::create($request->All());
        return redirect('tiposervicios')->with('mensaje','Tipo de servicio registrado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tiposervicio = Tiposervicio::findorFail($id);
        return view('tiposervicios.show',compact('tiposervicio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tiposervicio = Tiposervicio::find($id);
        return view('tiposervicios.edit',compact('tiposervicio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TiposervicioRequest $request, $id)
    {
        $tiposervicio = Tiposervicio::find($id);
        $tiposervicio->fill($request->All());
        $tiposervicio->save();
        return redirect('tiposervicios')->with('mensaje','El tipo de servicio se modificó con éxito');
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
