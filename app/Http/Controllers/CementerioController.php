<?php

namespace App\Http\Controllers;

use App\Cementerio;
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
        // $leftTopControls = ['document.getElementById("leftTopControl")']; // values must be html or javascript element
        // $gmap->injectControlsInLeftTop = $leftTopControls; // inject into map
        // $leftCenterControls = ['document.getElementById("leftCenterControl")'];
        // $gmap->injectControlsInLeftCenter = $leftCenterControls;
        // $leftBottomControls = ['document.getElementById("leftBottomControl")'];
        // $gmap->injectControlsInLeftBottom = $leftBottomControls;
        // $bottomLeftControls = ['document.getElementById("bottomLeftControl")'];
        // $gmap->injectControlsInBottomLeft = $bottomLeftControls;
        // $bottomCenterControls = ['document.getElementById("bottomCenterControl")'];
        // $gmap->injectControlsInBottomCenter = $bottomCenterControls;
        // $bottomRightControls = ['document.getElementById("bottomRightControl")'];
        // $gmap->injectControlsInBottomRight = $bottomRightControls;
        // $rightTopControls = ['document.getElementById("rightTopControl")'];
        // $gmap->injectControlsInRightTop = $rightTopControls;
        // $rightCenterControls = ['document.getElementById("rightCenterControl")'];
        // $gmap->injectControlsInRightCenter = $rightCenterControls;
        // $rightBottomControls = ['document.getElementById("rightBottomControl")'];
        // $gmap->injectControlsInRightBottom = $rightBottomControls;
        // $topLeftControls = ['document.getElementById("topLeftControl")'];
        // $gmap->injectControlsInTopLeft = $topLeftControls;
        // $topCenterControls = ['document.getElementById("topCenterControl")'];
        // $gmap->injectControlsInTopCenter = $topCenterControls;
        // $topRightControls = ['document.getElementById("topRightControl")'];
        // $gmap->injectControlsInTopRight = $topRightControls;

        

        $config = array();
        $config['center'] = '13.644985, -88.865193';
        $config['zoom'] = '19';
        $config['map_height'] = "100%";
        $config['scrollwheel'] = true;
        $config['drawing'] = true;
        $config['drawingDefaultMode'] = 'polygon';
        $config['drawingModes'] = array('polygon');
        $gmap->initialize($config);

        $marker = array();
        $marker['position'] = '13.645341, -88.865775';
        $marker['infowindow_content'] = 'clary dormite!';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
        $gmap->add_marker($marker);

        $marker = array();
        $marker['position'] = '13.645313, -88.865653';
        $marker['draggable'] = TRUE;
        $marker['animation'] = 'DROP';
        $gmap->add_marker($marker);

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
        //
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
