@extends('layouts.app')

@section('migasdepan')
<h1>
        Construcciones
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('/contrucciones') }}"><i class="fa fa-dashboard"></i> Construcciones</a></li>
        <li class="active">Detalle</li>
      </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Detalle</h4>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <span><b>Nombre del contribuyente:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$c->contribuyente->nombre}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Dirección inmueble:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$c->direccion_construccion}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Presupuesto:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>${{number_format($c->presupuesto,2)}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Impuesto:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>${{number_format($c->impuesto,2)}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Fiestas patronales:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>${{number_format($c->fiestas,2)}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Detalle imnueble</h4>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    <span><b>Número catastral:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$c->inmueble->numero_catastral}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">

                <div class="col-sm-12">
                    <span><b>Número de escritura:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$c->inmueble->numero_escritura}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Dirección:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$c->inmueble->direccion_inmueble}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">
                <div class="col-sm-12">
                    <span><b>Medidas (AnchoxLargo):</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$c->inmueble->ancho_inmueble}}x{{$c->inmueble->largo_inmueble}}</span>
                </div>
                <div class="clearfix"></div>   
                <hr style="margin-top: 3px; margin-bottom: 3px;">

                <br>
                <br>
                <div style="height:400px;" id="elmapita"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var lalat=parseFloat('<?php echo $c->inmueble->latitude ?>');
    var lalng=parseFloat('<?php echo $c->inmueble->longitude ?>');
    var contribuyente='<?php echo $c->contribuyente->nombre ?>';
    var escritura='<?php echo $c->inmueble->numero_escritura ?>';
    var numero_catastral='<?php echo $c->inmueble->numero_catastral ?>';
    var direccion='<?php echo $c->inmueble->direccion_inmueble ?>';

    $(document).ready(function(e){
        initMap(lalat,lalng);

        //imprimir reporte
        $(document).on("click",".imprime",function(e){
            e.preventDefault();
            window.print();
        });

        //abrir modal para reparar
        $(document).on("click",".reparar",function(e){
            e.preventDefault();
            $("#modal_reparar").modal("show");
        });

  
    });
    function initMap(lalat,lalng) {
			console.log(lalat,lalng);
            var map;
            var infowindow = new google.maps.InfoWindow();
            var contentString = '<div id="content">'+
            '<h1 id="firstHeading" class="firstHeading">'+contribuyente+'</h1>'+
            '<div id="bodyContent">'+
            '<p><b>Número de escritua: </b>'+escritura+'</p><br>'+
            '<p><b>Número catastral: </b>'+numero_catastral+'</p><br>'+
            '<p><b>Dirección: </b>'+direccion+'</p><br>'+
            '</div>'+
            '</div>';
        
			
			map = new google.maps.Map(document.getElementById('elmapita'), {
			center: {lat: lalat, lng: lalng},
			zoom: 17,   
			});

			marker = new google.maps.Marker({
				position: {lat: lalat, lng: lalng},
				map: map,
				title: numero_catastral,
			
				draggable: false,
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
        function cambiar(){
            var pdrs = document.getElementById('file-upload').files[0].name;
            document.getElementById('info').innerHTML = pdrs;
        }
</script>
@endsection