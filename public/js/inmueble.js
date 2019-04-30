$(document).ready(function(){
	//cargarContribuyente();
  $(document).on("click","#guardar_inmueble", function(e){
    var datos=$("#form_inmueble").serialize();
    var ruta = "/"+carpeta()+"/public/inmuebles";
    var token = $('meta[name="csrf-token"]').attr('content');
     $.ajax({
      url: ruta,
      headers: {'X-CSRF-TOKEN':token},
      type:'POST',
      dataType:'json',
      data:datos,

      success: function(json){
        if(json.mensaje=='exito'){
          window.location.href='../inmuebles';
          toastr.success('Registro creado exitosamente');
          $("#btncontribuyente").modal("hide");
        }
      },
      error : function(data){
          $.each(data.responseJSON.errors, function( key, value ) {
            toastr.error(value);
          });
        }
    });
  });

	$('#guardarcontribuyente').on("click", function(e)
  {
    var nombre = $("#nombre").val();
    var dui = $("#dui").val();
    var nit = $("#nit").val();
    var nacimiento = $("#nacimiento").val();
    var direccion = $("#direc").val();
    var telefono = $("#tel").val();
    var sexo = $('input[name=sexo]:checked').val();
    var motivo = $("#motivo").val();
    var ruta = "/"+carpeta()+"/public/contribuyentes";
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: ruta,
      headers: {'X-CSRF-TOKEN':token},
      type:'POST',
      dataType:'json',
      data:{nombre,dui,nit,nacimiento,direccion,telefono,sexo,motivo},

      success: function(){
        toastr.success('Registro creado exitosamente');
        $("#btncontribuyente").modal("hide");
        //cargarContribuyente();
      },
      error : function(data){
          $.each(data.responseJSON.errors, function( key, value ) {
          toastr.error(value);
      });
        }
    });
  });
  
});

  function cargarContribuyente(){
  	$.get('/'+carpeta()+'/public/contratos/listarcontribuyentes', function (data){
  		var html_select = '<option value="">Seleccione un contribuyente</option>';
  		for(var i=0;i<data.length;i++){
  			html_select +='<option value="'+data[i].id+'">'+data[i].nombre+'</option>'
  			//console.log(data[i]);
  			$("#contribuyente").html(html_select);
  		}
  	});
  }
  