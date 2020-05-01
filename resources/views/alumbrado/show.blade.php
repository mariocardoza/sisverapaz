@extends('layouts.app')

@section('migasdepan')
<h1>
        Alumbrado público
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('/alumbrado') }}"><i class="fa fa-lightbulb-o"></i> Todas</a></li>
        <li class="active">Gestión de alumbrado público</li>
      </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Información del alumbrado público</h4>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <span><b>Nombre de la persona que reportó:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$lampara->reporto}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Dirección:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$lampara->direccion}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Detalle de la falla:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$lampara->detalle}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Tipo de lámpara:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$lampara->tipo_lampara}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Fecha del reporte:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$lampara->fecha->format("d/m/Y")}}</span>
                </div>
                <br>
                <div class="col-sm-12 text-center">
                    <button type="button" data-id="{{$lampara->id}}" class="btn btn-success"><i class="fa fa-check"></i> Reparar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Ubicación de la lámpara reportada</h4>
            </div>
            <div class="panel-body">
                <div style="height:400px;" id="elmapita"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var lalat=parseFloat('<?php echo $lampara->lat ?>');
    var lalng=parseFloat('<?php echo $lampara->lng ?>');
    var detalle='<?php echo $lampara->detalle ?>';
    var direccion='<?php echo $lampara->direccion ?>';
    var reporto='<?php echo $lampara->reporto ?>';


    $(document).ready(function(e){
        initMap(lalat,lalng);
    })
    function initMap(lalat,lalng) {
			console.log(lalat,lalng);
            var map;
            var infowindow = new google.maps.InfoWindow();
            var contentString = '<div id="content">'+
            '<h1 id="firstHeading" class="firstHeading">'+detalle+'</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Reportó: </b>'+reporto+'</p><br>'+
            '<p><b>Dirección: </b>'+direccion+'</p><br>'+
            '</div>'+
            '</div>';
        
			
			map = new google.maps.Map(document.getElementById('elmapita'), {
			center: {lat: lalat, lng: lalng},
			zoom: 18,   
			});

			marker = new google.maps.Marker({
				position: {lat: lalat, lng: lalng},
				map: map,
				title: detalle,
				icon: '../img/lampara.png', // Path al nuevo icono,
				draggable: true,
            });
            
            google.maps.event.addListener(marker, 'click', (function(marker) {
              return function() {
                infowindow.setContent(contentString);
                infowindow.open(map, marker);
              }
            })(marker));

			marker.addListener('click', toggleBounce);
			

			
        }
        
        function toggleBounce() {
				if (marker.getAnimation() !== null) {
					marker.setAnimation(null);
				} else {
					marker.setAnimation(google.maps.Animation.BOUNCE);
				}
			}
</script>
@endsection