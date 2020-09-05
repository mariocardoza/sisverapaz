<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;

class CobroController extends Controller
{
    public function index(Request $request)
    {
         $facturas = Factura::orderBy('created_at','desc')->get();
         return view('pagos.index', compact('facturas'));
    }
}
