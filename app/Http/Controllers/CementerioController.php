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
        $gmap = new GMaps();
        $config = array();
        $config['center'] = '13.644985, -88.865193';
        $config['zoom'] = '19';
        $config['map_height'] = "100%";
        $config['scrollwheel'] = true;
        $config['drawing'] = true;
        $config['drawingDefaultMode'] = 'polygon';
        $config['drawingModes'] = array('polygon');
        $gmap->initialize($config);

        // $marker = array();
        // $marker['position'] = '13.645341, -88.865775';
        // $marker['infowindow_content'] = 'clary dormite!';
        // $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
        // $gmap->add_marker($marker);

        // $marker = array();
        // $marker['position'] = '13.645313, -88.865653';
        // $marker['draggable'] = TRUE;
        // $marker['animation'] = 'DROP';
        // $gmap->add_marker($marker);

        $map = $gmap->create_map();
        return view("cementerios.index", [
            "map"   => $map
        ]);
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
