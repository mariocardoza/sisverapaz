<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoCuenta;

class PagocuentaController extends Controller
{
    public function index($id)
    {
        $catorcena=\App\PeriodoProyecto::find($id);
        $pagos=PagoCuenta::where('estado',1)->where('catorcena_id',$id)->orderby('created_at')->get();
        return view('pagocuentas.index',compact('pagos','catorcena'));
    }
}
