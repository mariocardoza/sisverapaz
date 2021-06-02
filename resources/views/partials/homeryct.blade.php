@extends('layouts.app')

@section('migasdepan')
    <h1>
        Pagina principal
        <small>Control panel Registro y Control Tributario</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Pagina principal</li>
    </ol>

@endsection
@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{\App\Construccion::whereEstado('3')->count()}}</h3>
                <p>Construcciones</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{url('construcciones')}}" class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>
                <p>Recibos mes de {{strftime ("%B")}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Ver <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{cantcontri()}}</h3>
                <p>Contribuyentes Registrados</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ url('/contribuyentes') }}" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>65</h3>
                <p>Unique Visitors</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel">
          <h3 class="text-center">Ubicación de negocios morosos</h3>
          <div style="height: 300px;" id="mapita">
    
          </div>
        </div>
      </div>
</div>
@endsection
@section('scripts')
<script>
  let vista;let elcontador;
   var morosos=[];
   morosos=JSON.parse('<?php echo $morosos; ?>');
  $(document).ready(function(e){
    initMap();
    Highcharts.chart('container', {
      data: {
          table: 'datatable'
      },
      chart: {
          type: 'bar'
      },
      title: {
          text: 'Proveedores más utilizados'
      },
    
      yAxis: {
          allowDecimals: false,
          title: {
              text: 'Compras'
          }
      },
      tooltip: {
          formatter: function () {
              return '<b>' + this.series.name + '</b><br/>' +
                  this.point.y + ' ' + this.point.name.toLowerCase();
          }
      }
  });
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
     for(i = 0; i < morosos.length; i++ ){
       
       contentString[i] = '<div id="content">'+
            '<h1 id="firstHeading" class="firstHeading">'+morosos[i].nombre+'</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Dirección: </b>'+morosos[i].direccion+'<br>'+
            '<p><b>Deuda: </b>$'+morosos[i].deuda+'<br>'+
            '<p><a href="/contribuyentes/verpagosn/'+morosos[i].id+'" class="btn btn-info"><i class="fa fa-eye"></i></a>'+
            '</p>'+
            '</div>'+
            '</div>';
        }

        console.log(contentString)
        
        map = new google.maps.Map(document.getElementById('mapita'), {
		    center: {lat: 13.6445855, lng: -88.8731913},
          zoom: 15,
              
        });

        //map.mapTypes.set(customMapType);
        //map.setMapTypeId(customMapType);
        /*var marker = new google.maps.Marker({
            position: {lat: 13.6445855, lng: -88.8731913},
            map: map,
            title: 'Verapaz',
            icon: '../img/obrero.png' // Path al nuevo icono
        });*/
        for( i = 0; i < morosos.length; i++ ) {
          console.log(morosos[i].id);
            var position = new google.maps.LatLng(morosos[i].lat, morosos[i].lng);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: morosos[i].nombre,
                icon: 'img/tienda.png', // Path al nuevo icono,
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
