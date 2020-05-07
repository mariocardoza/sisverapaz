@extends('layouts.app')

@section('migasdepan')
<h1>
        Contribuyentes
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('/contribuyentes') }}"><i class="fa fa-home"></i> Contribuyentes</a></li>
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<div class="panel">
    <div class="row">
        <div class="col-md-12">
          <div class="page-header" style="overflow: hidden;">
            <div class="pull-left">
              <i class="fa fa-user"></i> {{$c->nombre}}<br />
              <small style="margin-top: 0px; margin-left: 28px">DUI: {{$c->dui}}</small>
            </div>
            <div class="btn-group pull-right"> 
                @if($c->estado==1)         
              <button title="Dar de baja" class="btn btn-danger baja" data-id="{{$c->id}}">
                  <i class="fa fa-thumbs-o-down"></i>
              </button>
            @else 
            <button title="dar de alta" class="btn btn-success restaurar" data-id="{{$c->id}}">
                <i class="fa fa-thumbs-o-up"></i>
            </button>
            @endif
              <button class="btn btn-primary" data-id="{{$c->id}}" id="edi_contri" title='Editar contribuyente'>
                <i class="fa fa-pencil"></i>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="invoice-info" >   
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>NIT:</b> {{$c->nit}}<br>
              <b>Teléfono:</b> {{$c->telefono}}<br>
              <b>Género:</b> {{$c->sexo}}<br>
              <b>Edad:</b> {{$c->nacimiento->age}}<br>
              <b>Fecha de nacimiento:</b> {{$c->nacimiento->format("d/m/Y")}}<br>
             </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
             <b>Dirección: </b>      
              <address>
                {{$c->direccion}}
              </address><br>
              @if($c->estado==2)
              <b>Contribuyente desabilitado el: </b> {{$c->fechabaja->format("d/m/Y")}}<br>
              <b>Por: </b> {{$c->motivo}} <br>
              @endif
            </div>
          </div>
      </div>

      <div class="row" style="clear:both;padding-top:30px;">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#inmuebles" data-toggle="tab">Inmuebles</a></li>
                <li><a href="#negocios" data-toggle="tab">Negocios</a></li>
            </ul>
            <div class="tab-content">
                <div class="active tab-pane" id="inmuebles" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
                    <div class="col-xs-12 table-responsive" style="padding-top: 30px;">
                        <div class="col-xs-12">
                            <div class="btn-group pull-right">
                              <button class="btn btn-primary" tooltip-placement='left' id="nuevo_inmueble" tooltip='Agregar inmueble'>
                                <i class="fa fa-plus-circle"></i>
                              </button>
                            </div>
                        </div>
                        <table class="table no-margin">
                          <thead>
                            <tr>
                              <th class="text-center"># Catastral</th>
                              <th class="text-center"># Escritura</th>
                              <th class="text-center">Metro Acera</th>
                              <th class="text-center">Ubicación</th>
                              <th class="text-center">Estado</th>
                              <th class="text-center"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($c->inmuebles as $i)
                            <tr>
                                <td class="text-center">{{$i->numero_catastral}}</td>
                                <td class="text-center"><span class="label label-success">{{$i->numero_escritura}}</span></td>
                                <td class="text-center">{{number_format($i->metros_acera,2)}}</td>
                                <td class="text-center">
                                  <button data-lat="{{$i->latitude}}" data-lng="{{$i->longitude}}" id="mapa_inmueble" class="btn btn-primary">Ver Ubicación</button>
                                </td>
                                <td class="text-center">
                                  @if($i->estado==1)
                                  <span class="label label-success">
                                    Activo
                                  </span>
                                  @else 
                                  <span class="label label-danger">
                                    Inactivo
                                  </span>
                                  @endif
                                </td>
                                <td class="text-center">
                                  <div class="btn-group text-align">
                                    <button class="btn btn-warning" ng-click='onViewCreateEditInmuebleController(true, item, $index)'>
                                      <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-success" ng-click="onViewTipoServicio(item.id);">
                                      <i class="fa fa-fw fa-dollar"></i>
                                    </button>
                                    @if($i->estado==1)
                                        <button class="btn btn-danger">
                                            <i class="fa fa-thumbs-o-down"></i>
                                        </button>
                                        @else 
                                        <button class="btn btn-success">
                                        <i class="fa fa-thumbs-o-up"></i>
                                        </button>
                                        @endif
                                  </div>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                </div>
                <div class="tab-pane" id="negocios" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
                    <div class="col-xs-12">
                        <div class="btn-group pull-right">
                          <button class="btn btn-primary" title='Agregar negocio'>
                            <i class="fa fa-plus-circle"></i>
                          </button>
                        </div>
                      </div>
                      <table class="table no-margin">
                        <thead>
                          <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Rubro</th>
                            <th class="text-center">Capital</th>
                            <th class="text-center">Porcentaje</th>              
                            <th class="text-center">Cobro</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($c->negocios as $i=> $n)
                          <tr>
                            <td class="text-center">{{$i+1}}</td>
                            <td class="text-center">{{$n->nombre}}</td>              
                            <td class="text-center"><span class="label label-success">{{$n->rubro->nombre}}</span></td>
                            <td class="text-center">${{number_format($n->capital,2)}}</td>
                            <td class="text-center">{{number_format(($n->rubro->porcentaje*100),2)}}% </td>
                            <td class="text-center">${{number_format($n->capital*$n->rubro->porcentaje,2)}}</td>
                            <td class="text-center">
                                @if($n->estado==1)
                                <span class="label label-success">
                                  Activo
                                </span>
                                @else 
                                <span class="label label-danger">
                                  Inactivo
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                              <div class="btn-group text-align">
                                <button class="btn btn-warning">
                                  <i class="fa fa-edit"></i>
                                </button>
                                @if($n->estado==1)
                                <button class="btn btn-danger">
                                    <i class="fa fa-thumbs-o-down"></i>
                                  </button>
                                @else 
                                <button class="btn btn-success">
                                  <i class="fa fa-thumbs-o-up"></i>
                                </button>
                                @endif
                                
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
      </div>
</div>
<div id="modal_aqui"></div>
@include('contribuyentes.modales')
@endsection

@section('scripts')
<script>
  var elid='<?php echo $c->id ?>'
  
  $(document).ready(function(e){

    //editar el contribuyente
    $(document).on("click","#edi_contri",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $.ajax({
        url:'../contribuyentes/'+id+"/edit",
        type:'get',
        dataType:'json',
        success: function(json){
          if(json[0]==1){
            $("#modal_aqui").empty();
            $("#modal_aqui").html(json[2]);
            $('.nit').inputmask("9999-999999-999-9", { "clearIncomplete": true });
            $('.dui').inputmask("99999999-9", { "clearIncomplete": true });
            $('.telefono').inputmask("9999-9999", { "clearIncomplete": true });
            $('.nacimiento').datepicker({
              selectOtherMonths: true,
              changeMonth: true,
              changeYear: true,
              dateFormat: 'dd-mm-yy',
              minDate: "-60Y",
              maxDate: "-18Y",
              format: 'dd-mm-yyyy'
    		    });
            $("#modal_editcontribuyente").modal("show");
          }
        }
      });
    });

    //form_edit
    $(document).on("click","#eform_econtribuyente",function(e){
      e.preventDefault();
      var id=$("#contri_id").val();
      var datos=$("#form_econtribuyente").serialize();
      $.ajax({
        url:'../contribuyentes/'+id,
        type:'put',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Contribuyente modificado con éxito");
            location.reload();
          }else{
            toastr.error("Ocurrió un error con el servidor, intente otra vez");
          }
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });

    //baja a un contribuyente
    $(document).on("click",".baja",function(e){
      var id=$(this).attr("data-id");
      swal({
        title: 'Motivo por el que da de baja',
        input: 'text',
        showCancelButton: true,
        confirmButtonText: 'Dar de baja',
        showLoaderOnConfirm: true,
        preConfirm: (text) => {
          return new Promise((resolve) => {
            setTimeout(() => {
              if (text === '') {
                swal.showValidationError(
                  'El motivo es requerido.'
                )
              }
              resolve()
            }, 2000)
          })
        },
        allowOutsideClick: () => !swal.isLoading()
      }).then((result) => {
        if (result.value) {
          var motivo=result.value;
          $.ajax({
            url:'../contribuyentes/baja/'+id,
            type:'post',
            dataType:'json',
            data:{motivo},
            success: function(json){
              if(json[0]==1){
                toastr.success("Usuario dado de baja");
                location.reload();
              }else{   
                  toastr.error("Ocurrió un error");
              }
            }, error: function(error){
              toastr.error("Ocurrió un error");
            }
          });
        }
      });
    });

    //restaurar contribuyente
    $(document).on("click",".restaurar",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
          title: 'Contribuyente',
          text: "¿Desea restaurar este contribuyente?",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '¡Si!',
          cancelButtonText: '¡No!',
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
          reverseButtons: true
        }).then((result) => {
          if (result.value) {
            modal_cargando();
            $.ajax({
              url:'../contribuyentes/alta/'+id,
              type:'post',
              dataType:'json',
              success: function(json){
                if(json[0]==1){
                  
                  toastr.success("Contribuyente restaurado");
                  location.reload();
                }else{
                  toastr.error("Ocurrió un error");
                  swal.closeModal();
                }
              }, error: function(error){
                toastr.error("Ocurrió un error");
                swal.closeModal();
              }
            });
            
          } else if (result.dismiss === swal.DismissReason.cancel) {
          }
        });
    });

    //mapa inmueble
    $(document).on("click","#mapa_inmueble",function(e){
      e.preventDefault();
      var lalat=parseFloat($(this).attr("data-lat"));
      var lalng=parseFloat($(this).attr("data-lng"));
      initMap1(lalat,lalng);
      $("#modal_mapainmueble").modal("show");
    });

    //modal nuevo inmueble
    $(document).on("click","#nuevo_inmueble",function(e){
      e.preventDefault();
      $("#modal_inmueble").modal("show");
      initMap();
    });

    //submit a inmueble
    $(document).on("submit","#form_inmueble",function(e){
      e.preventDefault();
      var datos=$("#form_inmueble").serialize();
      $.ajax({
        url:'../inmuebles/guardar',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Inmueble registrado con éxito");
            $("#form_inmueble").trigger("reset");
            $("#modal_inmueble").modal("hide");
            location.reload();
          }
          
          else{
            toastr.error('Ocurrió un error');
          }
          
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(i,v){
            toastr.error(v);
          });
          swal.closeModal();
        }
      });
    });
  });

  function initMap1(lalat,lalng) {
			console.log(lalat,lalng);
			var map;
			
			map = new google.maps.Map(document.getElementById('elmapaimueble'), {
			center: {lat: lalat, lng: lalng},
			zoom: 15,   
			});

			marker = new google.maps.Marker({
				position: {lat: lalat, lng: lalng},
				map: map,
				title: 'Inmueble',
				draggable: true,
			});

			marker.addListener('click', toggleBounce);
			

			marker.addListener( 'dragend', function (event)
			{
				//escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
				var lat = this.getPosition().lat();
				var lng = this.getPosition().lng();
			
			});
		}

			function toggleBounce() {
				if (marker.getAnimation() !== null) {
					marker.setAnimation(null);
				} else {
					marker.setAnimation(google.maps.Animation.BOUNCE);
				}
			}

      initMap = function () 
{
  
  
    //usamos la API para geolocalizar el usuario
        navigator.geolocation.getCurrentPosition(
          function (position){
            coords =  {
              lng: -88.87197894152527,
              lat: 13.643449058476703
            };
            setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
            
           
          },function(error){console.log(error);});
    
}



function setMapa (coords)
{   
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('elmapitainmueble'),
      
      {
        zoom: 15,
        center:new google.maps.LatLng(13.643449058476703,-88.87197894152527),

      });
      document.getElementById("lat").value = 13.643449058476703;
      document.getElementById("lng").value = -88.87197894152527;

      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),
      });
      toggleBounce();
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);
      
      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("lat").value = this.getPosition().lat();
        document.getElementById("lng").value = this.getPosition().lng();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
          'latLng': event.latLng
        }, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              $("#direcc").val(results[0].formatted_address);
              $("#ladireccion").text(results[0].formatted_address);
            }
          }
        });
      });
}

</script>
@endsection
