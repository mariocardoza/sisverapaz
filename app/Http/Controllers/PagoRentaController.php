<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoRenta;
use App\Bitacora;

class PagoRentaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagorentas = PagoRenta::all();
        return view('pagorentas.index', compact('pagorentas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $id = $request->id;
            $pagorenta = PagoRenta::find($id);
            if($pagorenta->desembolso->estado == 3)
            {
                $pagorenta->estado = 2;
                $pagorenta->save();
                return array(1,"Ya desembolsó");
            }
            else{
                return array(2,"No hay desembolso");
            }
        }

        catch(Exception $e){
            return array(-1,$e->getMessage());//Para saber porque falló
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
