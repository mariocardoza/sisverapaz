@extends('layouts.app')

@section('migasdepan')
<h1>
        Proyectos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Mapa de ubicaciones</li>
      </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">

            </div>
            <div class="box-body">
                <div id="mapita" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
  var proyectos=JSON.parse('<?php echo $proyectos; ?>');
  
$(document).ready(function(e){
    initMap();
});
function initMap() {
  var infowindow = new google.maps.InfoWindow();
    var map;
    var bounds = new google.maps.LatLngBounds();
    var customMapType = new google.maps.StyledMapType([
         {
           elementType: 'labels',
           stylers: [{visibility: 'off'}]
         }
       ], {
         name: 'Custom Style'
     });
     var customMapTypeId = 'custom_style';
     var contentString = new Array();
     for(i = 0; i < proyectos.length; i++ ){
       let contador=0;
       if(proyectos[i].avance==null)
      contador=0;
      else
      contador=proyectos[i].avance;
       
       contentString[i] = '<div id="content">'+
            '<h1 id="firstHeading" class="firstHeading">'+proyectos[i].nombre+'</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Código: </b>'+proyectos[i].codigo_proyecto+'<br>'+
            '<p><b>Dirección: </b>'+proyectos[i].direccion+'<br>'+
            '<p><b>Justificación: </b>'+proyectos[i].motivo+'<br>'+
            '<p><b>Monto: </b>$'+proyectos[i].monto.toFixed(2)+'<br>'+
            '<p><b>Avance: </b>'+contador+'%<br>'+
            '<p><b>Beneficiarios: </b>'+proyectos[i].beneficiarios+' habitantes<br>'+
            '</p>'+
            '</div>'+
            '</div>';
        }

        //console.log(contentString)
        
        map = new google.maps.Map(document.getElementById('mapita'), {
		  center: {lat: 13.6445855, lng: -88.8731913},
          zoom: 15,
             
        });

        
        /*var marker = new google.maps.Marker({
            position: {lat: 13.6445855, lng: -88.8731913},
            map: map,
            title: 'Verapaz',
            icon: '../img/obrero.png' // Path al nuevo icono
        });*/
        for( i = 0; i < proyectos.length; i++ ) {
            var position = new google.maps.LatLng(proyectos[i].lat, proyectos[i].lng);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: proyectos[i].nombre,
                icon: '../img/obrero.png', // Path al nuevo icono,
                style:'feature:all|element:labels|visibility:off'
            });
            // Center the map to fit all markers on the screen
            map.fitBounds(bounds);
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(contentString[i]);
                infowindow.open(map, marker);
              }
            })(marker, i));
        }

       
      }
</script>
@endsection