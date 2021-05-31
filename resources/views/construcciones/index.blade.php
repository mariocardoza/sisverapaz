@extends('layouts.app')

@section('migasdepan')
<h1>
        Construcciones
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/construcciones') }}"><i class="fa fa-dashboard"></i> Construcciones</a></li>
        <li class="active">Listado de construcciones</li>
      </ol>
@endsection

@section('content')
<style>
  .modal {
    position:absolute;
    overflow:scroll;
}
</style>
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3><br>
                <a href="javascript:void(0)" id="nuevo" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Contribuyente</th>
                  <th>Inmueble</th>
                  <th>Presupuesto</th>
                  <th>Impuesto</th>
                  <th>% Fiestas </th>
                  <th>Estado</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($construcciones as $index=> $construccion)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $construccion->contribuyente->nombre }}</td>
                    <td>{{ $construccion->inmueble->numero_escritura }}</td>
                    <td>${{ number_format($construccion->presupuesto,2) }}</td>
                    <td>${{ number_format($construccion->impuesto,2) }}</td>
                    <td>${{ number_format($construccion->fiestas,2) }}</td>
                      @if($construccion->estado==1)
                      <td>
                      <label for="" class="col-md-12 label-primary text-center">Pendiente</label>
                      </td>
                      @elseif($construccion->estado==2)
                      <td>
                      <label for="" class="col-md-12 label-danger text-center">Anulada</label>
                      </td>
                      @elseif($construccion->estado==3)
                      <td>
                      <label for="" class="col-md-12 label-success text-center">Recibo emitido</label>
                      </td>
                      @else
                      <td>
                      <label for="" class="col-md-12 label-success text-center">Pagado</label>
                    </td>
                      @endif
                    
                    <td>
                      @if($construccion->estado==1)
                      {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                      <a href="{{ url('construcciones/'.$construccion->id) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                      <a href="javascript:void(0)" class="btn btn-warning editar" data-id="{{$construccion->id}}"><span class="fa fa-edit"></span></a>
                      <a class="btn btn-danger" type="button" onclick={{ "baja(".$construccion->id.",'construcciones')" }}><span class="glyphicon glyphicon-trash"></span></button>
                      {{ Form::close() }}
                      @elseif($construccion->estado==2)
                      @elseif($construccion->estado==3)
                      <a href="{{ url('construcciones/'.$construccion->id) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                      <a class="btn btn-success vista_previa" href="{{url ('reportestesoreria/reciboc/'.$construccion->id)}}" target="_blank"><i class="fa fa-print"></i></a>
                      @else
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
<div class="modal fade" tabindex="-1" id="modal_construccion" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar una construcción</h4>
      </div>
      <div class="modal-body">
          <form id="form_construccion" class="">
              <div class="row">
                  <div class="col-md-12">
                    @include('construcciones.formulario')
                  </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_contribuyente" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar una construcción</h4>
      </div>
      <div class="modal-body">
          <form id="form_contribuyente" class="">
              <div class="row">
                  <div class="col-md-12">
                    @include('contribuyentes.formulario')
                  </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" id="cerrar_contri">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" id="modal_inmueble" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar un inmueble</h4>
      </div>
      <div class="modal-body">
          <form id="form_inmueble" class="">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label"># Catastral</label>
                    <input type="text" name="numero_catastral" autocomplete="off" placeholder="Digite el número catastral" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="control-label">Ancho inmueble (mts)</label>
                        <input type="number" name="ancho_inmueble" placeholder="Digite el ancho" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="" class="control-label">Largo inmueble (mts)</label>
                        <input type="number" name="largo_inmueble" placeholder="Digite el largo" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label"># Escritura</label>
                    <input type="text" name="numero_escritura" autocomplete="off" placeholder="Digite el número de escritura" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label">Metros de acera</label>
                    <input type="text" name="metros_acera" autocomplete="off" placeholder="Digite la longitud de la acera (mts)" class="form-control">
                  </div>
                </div>
                <div class="col-md-12">
                  <input type="hidden" name="lat" id="lat">
                  <input type="hidden" name="lng" id="lng">
                  <input type="hidden" name="direccion_inmueble" id="direcc">
                  <input type="hidden" name="contribuyente_id" id="contriid">

                  <div class="form-group">
                    <label for="" class="control-label">Dirección</label>
                    <textarea class="form-control" name="direccion_inmueble" id="ladireccion" rows="2"></textarea>
                    <h5 id="ladireccion"></h5>
                  </div>
                </div>
                <div class="col-md-12">
                  <div id="elmapita" style="height:350px;"></div>
                </div>
            </div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" id="cerrar_inmueble">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>

<div id="modal_aqui"></div>
@endsection
@section('scripts')
<script>
  $(document).ready(function(e){
    initMap();
   
    //abrir nuevo modal
    $(document).on("click","#nuevo",function(e){
      e.preventDefault();
      $("#modal_construccion").modal("show");
    });

    //editar construccion
    $(document).on("click",".editar",function(e){
      e.preventDefault();
      let id=$(this).attr("data-id");
      $.ajax({
        url:'construcciones/'+id+'/edit',
        type:'get',
        dataType:'json',
        success:function(json){
          if(json[0]==1){
            $("#modal_aqui").empty();
            $("#modal_aqui").html(json[2]);
            $(".chosen-select-width").chosen({'width':'100%'});
            $("#modal_econstruccion").modal("show");
          }
        }
      });
    });

    //el editar
    $(document).on("click",".eledit",function(e){
      e.preventDefault();
      var datos=$("#form_econstruccion").serialize();
      var id=$(this).attr("data-id");
      modal_cargando();
      $.ajax({
        url:'construcciones/'+id,
        type:'put',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Registrado con éxito");
            location.reload();
          }
          else{
            if(json[0]==2){
            console.log(json);
            toastr.info(json[2]);
            swal.closeModal();
            }else{
              toastr.error("Ocurrió un error");
              swal.closeModal();
            }
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

    //change a contribuyente
    $(document).on("change","#elcontribuyente",function(e){
      e.preventDefault();
      var id=$(this).val();
      $.ajax({
        url:'construcciones/inmuebles/'+id,
        type:'get',
        dataType:'json',
        success:function(json){
          if(json[0]==1){
            $("#elinmueble").empty();
            $("#elinmueble").html(json[2]);
            $("#elinmueble").trigger("chosen:updated");
          }
        },
        error: function(error){
          toastr.error("Ocurrio un error, intente de nuevo");
        }
      })
    });

    //change a el inmueble
    $(document).on("change","#elinmueble",function(e){
      e.preventDefault();
      let id=$(this).val();
      if(id>0){
        let direccion="";
        direccion=$("#elinmueble option:selected").attr("data-direccion");
        $(".dir_cons").val(direccion);
      }else{
        $(".dir_cons").val("");
      }
    });

    //submit de form_construccion
    $(document).on("submit","#form_construccion",function(e){
      e.preventDefault();
      var datos=$("#form_construccion").serialize();
      modal_cargando();
      $.ajax({
        url:'construcciones',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Registrado con éxito");
            location.reload();
          }
          else{
            if(json[0]==2){
            console.log(json);
            toastr.info(json[2]);
            swal.closeModal();
            }else{
              toastr.error("Ocurrió un error");
              swal.closeModal();
            }
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

    //Modal para nuevo contribuynte
    $(document).on("click","#nuevo_contri",function(e){
      e.preventDefault();
      $("#modal_contribuyente").modal("show");
      $("#modal_construccion").modal("hide");
    });

    //modal para un nuevo inmueble
    $(document).on("click","#nuevo_inmueble",function(e){
      e.preventDefault();
      var contribuyente=$("#elcontribuyente").val();
      if(contribuyente!=''){
        $("#modal_inmueble").modal("show");
        $("#modal_construccion").modal("hide");
        $("#contriid").val(contribuyente);
      }else{
        swal('Aviso','Debe selecionar el contribuyente','warning');
      }
      
    });

    //cerrar modal contribuyente
    $(document).on("click","#cerrar_contri,#cerrar_inmueble",function(e){
      e.preventDefault();
      $("#modal_contribuyente").modal("hide");
      $("#modal_inmueble").modal("hide");
      $("#modal_construccion").modal("show");
    });

    //submit de form_contribuyente
    $(document).on("submit","#form_contribuyente",function(e){
      e.preventDefault();
      var datos=$("#form_contribuyente").serialize();
      $.ajax({
        url:'contribuyentes',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Contribuyente registros con éxito");
            $("#elcontribuyente").append('<option selected value="'+json[2].id+'">'+json[2].nombre+'</option>');
            $("#elcontribuyente").trigger("chosen:updated");
            $("#form_contribuyente").trigger("reset");
            $("#modal_contribuyente").modal("hide");
            $("#modal_construccion").modal("show");
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

    //submit de form_inmueble
    $(document).on("submit","#form_inmueble",function(e){
      e.preventDefault();
      var datos=$("#form_inmueble").serialize();
      $.ajax({
        url:'inmuebles/guardar',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Inmueble registrado con éxito");
            $("#elinmueble").append('<option selected data-direccion="'+json[2].direccion+'" value="'+json[2].id+'">'+json[2].numero_escritura+'</option>');
            $("#elinmueble").trigger("chosen:updated");
            $("#elinmueble").trigger("change");
            $("#form_inmueble").trigger("reset");
            $("#modal_inmueble").modal("hide");
            $("#modal_construccion").modal("show");
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

  initMap = function () 
{
  
  
    //usamos la API para geolocalizar el usuario
        /*navigator.geolocation.getCurrentPosition(
          function (position){*/
            coords =  {
              lng: -88.87197894152527,
              lat: 13.643449058476703
            };
            setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
            
           
          //},function(error){console.log(error);});
    
}



function setMapa (coords)
{   
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('elmapita'),
      
      {
        zoom: 16,
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
              $("#ladireccion").val(results[0].formatted_address);
            }
          }
        });
      });
}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}
</script>
@endsection