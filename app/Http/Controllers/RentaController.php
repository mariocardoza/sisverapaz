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
}
