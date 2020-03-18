<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Renta;

class RentaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','api']);
    }

    public function index()
    {
        $rentas=Renta::all();
        return view('rentas.index',compact('rentas'));
    }

    public function update($id, Request $request)
    {
        try{
            $renta=Renta::find($id);
            $renta->fill($request->all());
            $renta->save();
            return array(1,$renta);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }
}
