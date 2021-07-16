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
<style>
	.subir{
		padding: 5px 10px;
		background: #f55d3e;
		color:#fff;
		border:0px solid #fff;
	}
	
	.skin-blue{
	  padding-right: 0px !important;
	}
	 
	.subir:hover{
		color:#fff;
		background: #f7cb15;
	}
	</style>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Información del alumbrado público</h4>
            </div>
            <div class="panel-body">
                <div class="col-sm-12">
                    @if($lampara->estado==1)
                    <span><label for="" class="label-primary">Pendiente</label></span>
                    @elseif($lampara->estado==2)
                    <span><label for="" class="label-danger">Anulada</label></span>
                    @else 
                    <span><label for="" class="label-success">Reparada</label></span>
                    @endif
                </div>
                <div class="col-sm-12">
                    <span><b>Nombre de la persona que reportó:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$lampara->reporto}}</span>
                </div>
                <div class="clearfix"></div>
                <div class="col-sm-12">
                    <span><b>Correo electrónico de la persona que reportó:</b></span>
                </div>
                <div class="col-sm-12">
                    <span>{{$lampara->email}}</span>
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
                    @if($lampara->estado==1)
                    <button type="button" data-id="{{$lampara->id}}" class="btn btn-success hidden-print reparar"><i class="fa fa-check"></i> Reparar</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Bitácora</h4>
            </div>
            <div class="panel-body">
                @foreach ($lampara->bitacora as $b)
                <div class="col-sm-12">
                    <span><b>Fecha: </b>{{$b->fecha->format("d/m/Y")}}</span>
                </div>
                <div class="col-sm-12">
                    <span>{{$b->accion}}</span>
                </div>
                @if($b->empleado!='')
                <div class="col-sm-12">
                    <span><b>Empleado: </b>{{$b->empleado}}</span>
                </div>
                @endif
                <div class="clearfix"></div>   
                <hr style="margin-top: 6px; margin-bottom: 3px;">
                @endforeach
            </div>
        </div>

    </div>
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Ubicación de la lámpara reportada <button class="btn btn-danger pull-right imprime hidden-print"><i class="fa fa-print"></i> Imprimir</button></h4>
                
            </div>
            <div class="panel-body">
                <div style="height:400px;" id="elmapita"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_reparar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Reparar</h4>
			</div>
			<div class="modal-body">
				<form id="form_reparar">
					<div class="form-group">
						<label for="">Nombre del técnico</label>
						<input type="text" name="empleado" autocomplete="off" class="form-control">
						<input type="hidden" name="id" autocomplete="off" value="{{$lampara->id}}" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="">Detalle de la reparación</label>
                        <textarea name="detalle_reparacion" autocomplete="off" id="" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Fecha de la reparación</label>
                        <input type="text" class="form-control fechita" autocomplete="off" name="fecha_reparacion">
                    </div>

                    <label for="file-upload" class="subir">
                        <i class="glyphicon glyphicon-cloud"></i> Subir archivo
                    </label>
                    <input id="file-upload" onchange='cambiar()' name="archivo" type="file" style='display: none;'/>
                    <div id="info"></div>
				
			</div>
			<div class="modal-footer">
				<center>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </center>
            </form>
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

        //imprimir reporte
        $(document).on("click",".imprime",function(e){
            e.preventDefault();
            var body               = $('body');
            var appendMap          = $('#elmapita');
            var printContainer     = $('<div>');
            var mapContainer       = $('.panel-body');    
            printContainer
            .prepend(appendMap)
            .addClass('print-container')
            .css('position', 'relative')
            .height(mapContainer.height())
            .append(mapContainer)
            .prependTo(body);
            window.print();
        });

        //abrir modal para reparar
        $(document).on("click",".reparar",function(e){
            e.preventDefault();
            $("#modal_reparar").modal("show");
        });

        //reparar la lampara
        $(document).on("submit","#form_reparar",function(e){
            e.preventDefault();
        modal_cargando();
        // agrego la data del form a formData
        var formData = new FormData(this);
        //formData.append('_token', $('input[name=_token]').val());
      
        $.ajax({
            type:'POST',
            url:'../alumbrado/reparar',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data[0]==1){
                  toastr.success("Lámpara reparada");
                  $("#modal_reparar").modal("hide");
                  $("#form_reparar").trigger("reset");
                  swal.closeModal();
                  location.reload();
                }
            },
            error: function(error){
              $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
                swal.closeModal();
              });
            }
        });

        });
    });
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
			zoom: 17,   
			});

			marker = new google.maps.Marker({
				position: {lat: lalat, lng: lalng},
				map: map,
				title: detalle,
				icon: '../img/lampara.png', // Path al nuevo icono,
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