@extends('layouts.app')

@section('migasdepan')
<h1>
	Configuraciones
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/cuentas') }}"><i class="fa fa-home"></i>Inicio</a></li>
	<li class="active">Configuraciones de la alcaldía</li> </ol>
@endsection

@section('content')
<div class="">
	<div class="row">
		<div class="col-md-3">
			<div class="panel">
				<div class="panel-body">
					<p>
            Esta sección es para modificar información básica de la alcaldía como pueden ser: nombre del alcalde, el logo de la alcaldía o los porcentajes de IVA y Renta.
          </p>
				</div>
			</div>
        </div>
        <div class="col-md-8">
            @include('errors.validacion')
            <div class="nav-tabs-custom" style=" ">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#alcaldia" data-toggle="tab">Datos de la alcaldía</a></li>
                  <li><a href="#logo" data-toggle="tab">Logo</a></li>
                  <li><a href="#alcalde" data-toggle="tab">Datos del alcalde</a></li>
                  <li><a href="#limites" data-toggle="tab">Límites de los proyectos</a></li>
                  <li><a href="#porcentajes" data-toggle="tab">Porcentajes</a></li>
                  <li><a href="#retenciones" data-toggle="tab">Retenciones</a></li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="alcaldia" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
                    <div class="panel-body">

                        @if($configuraciones != null)
                          {{ Form::model($configuraciones, array('method' => 'put', 'class' => '' , 'route' => array('configuraciones.ualcaldia', $configuraciones->id))) }}
                        @else
                          {{ Form::open(['action'=> 'ConfiguracionController@alcaldia', 'class' => '']) }}
                        @endif
                        @include('configuraciones.alcaldia')
                        @if($configuraciones != null)
                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                  <button type="submit" class="btn btn-success">
                                      <span class="glyphicon glyphicon-floppy-disk"> Registrar</span>
                                  </button>
                              </div>
                          </div>
                        @else
                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                  <button type="submit" class="btn btn-success">
                                      <span class="glyphicon glyphicon-floppy-disk"> Registrar</span>
                                  </button>
                              </div>
                          </div>
                      @endif
            
                      {{Form::close()}}
                      </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="logo">
                    <p class="text-center">Haga click sobre la imagen, seleccione el logo de su elección y le aparecerá la opción de guardar</p>
                    <div class="panel-body text-center">
                        <h3 class="text-center">Modificar logo de la alcaldía</h3>
                        @if($configuraciones!='')
                        <img src="{{ asset('img/logos/'.$configuraciones->escudo_alcaldia) }}" id="img_file" width="150" height="200" class="user-image" alt="User Image">
                        <form method='post' action="{{ url('configuraciones/logo/'.$configuraciones->id) }}" enctype='multipart/form-data'>
                        @else 
                        <img src="{{ asset('img/logos/escudo.png') }}" id="img_file" width="150" height="200" class="user-image" alt="User Image">
                        <form method='post' action="{{ url('configuraciones/logog') }}" enctype='multipart/form-data'>
                        @endif
                                  {{csrf_field()}}
                                
                          <div class='form-group text-center'>
                            <input type="file" class="hidden" name="logo" id="file_1" />
                            <div class='text-danger'>{{$errors->first('avatar')}}</div>
                          </div>
                          <button type='submit' class='btn btn-primary elsub' style="display: none;">Cambiar</button>
                        
                              </form>
                    </div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="alcalde">
                      <div class="panel">
                        <div class="panel-body">
                            @if($configuraciones != null)
                              {{ Form::model($configuraciones, array('method' => 'put', 'class' => '','autocomplete'=>'off' , 'route' => array('configuraciones.ualcalde', $configuraciones->id))) }}
                            @else
                              {{ Form::open(['action'=> 'ConfiguracionController@alcalde', 'class' => '','autocomplete'=>'off']) }}
                            @endif
                            @include('configuraciones.alcalde')
                            @if($configuraciones != null)
                              <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                  <button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-floppy-disk"> Registrar</span>
                                  </button>
                                </div>
                              </div>
                            @else
                            <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                  <span class="glyphicon glyphicon-floppy-disk"> Registrar</span>
                                </button>
                              </div>
                            </div>
                          @endif
                          {{Form::close()}}
                          </div>
                      </div>
                  </div>

                  <div class="tab-pane" id="limites">
                    <div class="panel">
                        <div class="panel-body">
                            @if($configuraciones != null)
                              {{ Form::model($configuraciones, array('method' => 'put', 'class' => '','autocomplete'=>'off' , 'route' => array('configuraciones.ulimites', $configuraciones->id))) }}
                            @else
                              {{ Form::open(['action'=> 'ConfiguracionController@limitesproyecto', 'class' => '','autocomplete'=>'off']) }}
                            @endif
                            @include('configuraciones.limites')
                            @if($configuraciones != null)
                              <div class="form-group">
                                <div class="col-md-6 ">
                                  <button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-floppy-disk"> Registrar</span>
                                  </button>
                                </div>
                              </div>
                            @else
                            <div class="form-group">
                              <div class="col-md-6">
                                <button type="submit" class="btn btn-success">
                                  <span class="glyphicon glyphicon-floppy-disk"> Registrar</span>
                                </button>
                              </div>
                            </div>
                          @endif
                          {{Form::close()}}
                          </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="porcentajes">
                    <div class="panel">
                      <div class="panel-body">
                        <div class="row">
                          @foreach($porcentajes as $p)
                          <div class="col-md-3">
                            <label for="" class="control-label">% {{$p->nombre}}</label>
                            <div class="input-group">
                              <input type="number" min="0" value="{{$p->porcentaje}}"  name="porcentaje" class="form-control {{$p->nombre_simple}}">
                              <span class="input-group-btn">
                                <button type="button" data-porcen="{{$p->nombre_simple}}" data-id="{{$p->id}}" class="btn btn-success porcen"><i class="fa fa-refresh"></i></button>
                              </span>
                            </div>
                          </div>
                          @endforeach 
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="tab-pane" id="retenciones">
                    <div class="panel">
                      <div class="panel body">
                        <div class="row">
                          @foreach($retenciones as $r)
                          <div class="col-md-3">
                            <label for="" class="control-label">% {{$r->nombreCompleto($r->nombre)}}</label>
                            <div class="input-group">
                              <input type="number" min="0" value="{{$r->porcentaje}}"  name="porcentaje" class="form-control {{$r->nombre}}">
                              <span class="input-group-btn">
                                <button type="button" data-reten="{{$r->nombre}}" data-id="{{$r->id}}" class="btn btn-success reten"><i class="fa fa-refresh"></i></button>
                              </span>
                            </div>
                          </div>
                          @endforeach 
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
        </div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready(function(e){

    //Guardar o editar alcaldia


  	$(document).on("click", "#img_file", function (e) {
        $("#file_1").click();
    });

    $(document).on("change", "#file_1", function(event) {
        validar_archivo($(this));
    });

    $(document).on("click","#subir_imagen",function(e){
    	var elid=$("#elid").val();
    	insertar_imagen($("#file_1"),elid);
    });

    ///cambiar el porcentaje
    $(document).on("click",".porcen",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      var input=$(this).attr("data-porcen");
      var elvalor=$("."+input).val();
      modal_cargando();
      $.ajax({
        url:'configuraciones/porcentajes',
        type:'POST',
        dataType:'json',
        data:{id,porcentaje:elvalor},
        success: function(json){
          if(json[0]==1){
            toastr.success("Porcentaje actualizado con éxito");
            location.reload();
          }else{
            swal.closeModal();
            toastr.error("Ocurrió un error");
          }
        },
        error: function(error){
          swal.closeModal();
        }
      });
    });

    //cambiar el porcentaje a las retenciones /// ISSS, AFP...
    $(document).on("click",".reten",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      var input=$(this).attr("data-reten");
      var elvalor=$("."+input).val();
      modal_cargando();
      $.ajax({
        url:'configuraciones/retenciones',
        type:'POST',
        dataType:'json',
        data:{id,porcentaje:elvalor},
        success: function(json){
          if(json[0]==1){
            toastr.success("Porcentaje de la retención actualizado con éxito");
            location.reload();
          }else{
            swal.closeModal();
            toastr.error("Ocurrió un error");
          }
        },
        error: function(error){
          swal.closeModal();
        }
      });
    });
  });

  function validar_archivo(file){
  $("#img_file").attr("src","../img/photo.svg");//31.gif
      //var ext = file.value.match(/\.(.+)$/)[1];
       //Para navegadores antiguos
       if (typeof FileReader !== "function") {
          $("#img_file").attr("src",'../img/photo.svg');
          return;
       }
       var Lector;
       var Archivos = file[0].files;
       var archivo = file;
       var archivo2 = file.val();
       if (Archivos.length > 0) {

          Lector = new FileReader();

          Lector.onloadend = function(e) {
              var origen, tipo, tamanio;
              //Envia la imagen a la pantalla
              origen = e.target; //objeto FileReader
              //Prepara la información sobre la imagen
              tipo = archivo2.substring(archivo2.lastIndexOf("."));
              console.log(tipo);
              tamanio = e.total / 1024;
              console.log(tamanio);

              //Si el tipo de archivo es válido lo muestra, 

              //sino muestra un mensaje 

              if (tipo !== ".jpeg" && tipo !== ".JPEG" && tipo !== ".jpg" && tipo !== ".JPG" && tipo !== ".png" && tipo !== ".PNG") {
                  $("#img_file").attr("src",'../img/photo.svg');
                  $("#error_formato1").removeClass('hidden');
                  //$("#error_tamanio"+n).hide();
                  //$("#error_formato"+n).show();
                  console.log("error_tipo");
                  
              }
              else{
                  $("#img_file").attr("src",origen.result);
                  $("#error_formato1").addClass('hidden');
                  $(".elsub").show();
              }


         };
          Lector.onerror = function(e) {
          console.log(e)
         }
         Lector.readAsDataURL(Archivos[0]);
  }
}

function insertar_imagen(archivo,elid){
        var file =archivo.files;
        var formData = new FormData();
        formData.append('formData', $("#form_logo"));
        var data = new FormData();
         //Append files infos
         jQuery.each(archivo[0].files, function(i, file) {
            data.append('file-'+i, file);
         });

         console.log("data",data);
         $.ajax({  
            url: "configuraciones/logo",  
            type: "POST", 
            dataType: "json",  
            data: {data,elid},  
            cache: false,
            processData: false,  
            contentType: false, 
            context: this,
            success: function (json) {
                console.log(json);

            }
        });
    }
</script>
@endsection
