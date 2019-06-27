@extends('layouts.app')

@section('migasdepan')
<h1>
	Registro de cuentas
</h1>
<ol class="breadcrumb">
	<li><a href="{{ url('/cuentas') }}"><i class="fa fa-dashboard"></i>Configuracion básica de la Alcaldía</a></li>
	<li class="active">Registro</li> </ol>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">Configuraciones</div>
				<div class="panel-body">
					@include('errors.validacion')
          			@include('configuraciones.formulario')
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
  $(document).ready(function(e){
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
