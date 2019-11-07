<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoCuenta;

class PagocuentaController extends Controller
{
    public function index()
    {
        $pagos=PagoCuenta::where('estado',1)->orderby('created_at')->get();
        return view('pagocuentas.index',compact('pagos'));
    }
}
