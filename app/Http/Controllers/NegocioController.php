<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NegocioRequest;

// Models
use App\Negocio;
use App\Contribuyente;
use App\Rubro;

class NegocioController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $negocios = Negocio::all();
        return view('negocios.index', compact("negocios"));
    }

    public function guardarContribuyente(Request $request)
    {
        if($request->ajax())
        {
            Contribuyente::create($request->All());
            return response()->json([
                'mensaje' => 'Registro creado']);
        }
    }

    public function listarContribuyentes()
    {
        return Contribuyente::where('estado',1)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rubros = Rubro::pluck('nombre', 'id');
        $contribuyentes = Contribuyente::pluck('nombre', 'id');
        return view('negocios.create', compact('contribuyentes', 'rubros'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameters = $request->all();
        $negocios = Negocio::create([
            'contribuyente_id'  => $parameters['contribuyente'],
            'nombre'            => $parameters['object']['nombre'],
            'capital'           => $parameters['object']['capital'],
            'direccion'         => $parameters['object']['direccion'],
            'rubro_id'          => $parameters['object']['rubro_id'],
            'lat'               => $parameters['object']['lat'],
            'lng'               => $parameters['object']['lng']
        ]);

        if($negocios) {
            return array(
                "response"  => true,
                "message"   => 'Hemos agregado con exito al nuevo contribuyente',
                "data"      => Negocio::where('id', $negocios['id'])->with('rubro')->first()
            );
        }else {
            return array(
                "response"  => false,
                "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
            );
        }
        //Negocio::create($request->All());
        //bitacora('Registró un negocio');
        // return redirect('negocios')->with('mensaje','Registro almacenado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $negocio = Negocio::findorFail($id);
        return view('negocios.show', compact('negocio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit(Negocio $negocio)
    // {
    //     $rubros = Rubro::pluck('nombre', 'id');
    //     $contribuyentes = Contribuyente::pluck('nombre', 'id');
    //     return view('negocios.edit', compact('negocio', 'rubros', 'contribuyentes'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
      $parameters = $request->All();
      $negocio = Negocio::find($id);
      $negocio->nombre = $parameters['object']['nombre'];
      $negocio->capital = $parameters['object']['capital'];
      $negocio->rubro_id = $parameters['object']['rubro_id'];

      if($negocio->save()){
        return array(
          "response"  => true,
          "message"   => 'Hemos actualizado con exito al negocio',
          "data"      => Negocio::where('id', $negocio['id'])->with('rubro')->first()
        );        
      }else{
        return array(
          "response"  => false,
          "message"   => 'Tenemos problema con el servidor por le momento. intenta mas tarde'
        );
      }
    }

    public function viewMapa($id) {
        $negocio = Negocio::findorFail($id);
        return view('negocios.mapa', compact('negocio'));
    }

    public function mapas(Request $request)
    {
        $all = $request->all();
        $negocio = Negocio::findOrFail($all['id']);
        $negocio->lat = $all['lat'];
        $negocio->lng = $all['lng'];
        $negocio->save();
        return $negocio;        
    }

    public function mapa()
    {
        return view('negocios.mapaGlobal');
    }

    public function mapasAll()
    {
        return Negocio::where('lat', '!=', 0)
            ->where('lng', '!=', 0)
            ->with('contribuyente', 'rubro')->get();
    }

    // public function negocioPostControllerAdd (Request $request) {
    //     $parameters = $request->all();
    //     return $parameters;
    // }
}
