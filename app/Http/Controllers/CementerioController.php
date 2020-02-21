<?php

namespace App\Http\Controllers;

use App\Cementerio;
use App\CementeriosPosiciones;
use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\GMaps;

class CementerioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cementerio = Cementerio::first();
        $isDrawing = true;
        
        $gmap = new GMaps();
        $config = array();
        $config['center'] = '13.644985, -88.865193';
        $config['zoom'] = '19';
        $config['map_height'] = "100%";
        $config['scrollwheel'] = true;        
        $config['drawingModes'] = array('polygon');
        
        if ($cementerio) {
            $isDrawing = false;
            $polygon = array();
            $polygon['points'] = self::generatePointsArray($cementerio->posiciones);
            $polygon['strokeColor'] = '#000099';
            $polygon['fillColor'] = '#000099';
            $gmap->add_polygon($polygon);
        } else { 
            $config['drawing'] = true;
            $config['drawingDefaultMode'] = 'polygon';            
        }
        
        $gmap->initialize($config);
        $map = $gmap->create_map();
        return view("cementerios.index", [
            "map"           => $map,
            "isDrawing"     => $isDrawing,
            "cementerio"    => $cementerio
        ]);
    }

    private function generatePointsArray($posiciones) {
        $response = array();
        foreach ($posiciones as $value) {
            array_push($response, $value['latitud'].', '.$value['longitud']);
        }       
        return $response; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();

        $cementerio = new Cementerio;
        $cementerio->nombre = $params["form"]["nombre"];
        $cementerio->maximo = $params["form"]["maximo"];
        if($cementerio->save()) {
            foreach ($params["pointers"] as $key => $value) {    
                $posion = new CementeriosPosiciones;
                $posion->latitud = $value[0];
                $posion->longitud = $value[1];
                $posion->cementerio_id = $cementerio->id;
                $posion->save();
            }
            // por si todo sale bien
            return $cementerio;
        } else {
            // por si hay error
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cementerio  $cementerio
     * @return \Illuminate\Http\Response
     */
    public function show(Cementerio $cementerio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cementerio  $cementerio
     * @return \Illuminate\Http\Response
     */
    public function edit(Cementerio $cementerio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cementerio  $cementerio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cementerio $cementerio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cementerio  $cementerio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cementerio $cementerio)
    {
        //
    }
}
