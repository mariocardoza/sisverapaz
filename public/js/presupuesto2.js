var monto_total=0.0;
var dataJson;
var html_select = '';
$(document).ready(function(){
  var idpresupuesto = $("#presuid").val();
  var it=$("#itemid").val();
  listarcatalogo(idpresupuesto,it);
  listarunidades();
  traersesion();
  $("#agregaratabla").on("click", function(e) {

 //
      e.preventDefault();
          catalogo = $("#catalogo").val() || 0,
          texto =$("#catalogo option:selected").text(),
          cantidad  = $("#cantidad").val() || 0,
          unidad = $("#catalogo option:selected").attr('data-unidad'),
          monto = $("#monto").val(),
          existe = $("#catalogo option:selected");
          precio = $("#precio").val() || 0;
          descripcion=texto.replace(" ","_");

      if(cantidad && precio && catalogo){
          dataJson = JSON.stringify({ catalogo: parseInt(catalogo),descripcion:descripcion,cantidad:parseInt(cantidad),precio: parseFloat(precio), unidad:unidad });

          guardarsesion(dataJson);

          $(existe).css("display", "none");
          $("#catalogo").val("");
          $("#catalogo").trigger('chosen:updated');
          clearForm();
      }else{
        swal(
           '¡Aviso!',
           'Debe llenar todos los campos',
           'warning'
         )
      }
  });

  $(document).on("click", "#delete-btn", function (e) {
      var tr     = $(e.target).parents("tr"),
          totaltotal  = $("#totalEnd");
      var data = JSON.parse($(e.currentTarget).attr('data-data'));
      var totalFila=parseFloat(data.precio)*parseFloat(data.cantidad);
      monto_total = parseFloat(totaltotal.text()) - parseFloat(totalFila);
      quitar_mostrar($(tr).attr("data-catalogo"));
      //llamar a la funcion eliminar sesiones
      eliminarsesion(data.catalogo);
      //recarga el select box de catalogos
      //listarcatalogo(idpresupuesto,it);
      //remover la fila
      tr.remove();
      $("#total").val(onFixed(monto_total,2));
      $("#pie #totalEnd").text(onFixed(monto_total,2));
  });

  $(document).on("click","#edit-btn", function(e){
    //obtener los datos de un json y enviarlos al formulario
    var data = JSON.parse($(e.currentTarget).attr('data-data'));
    //datos para buscar en el select box
    html_select += '<option value="'+data.catalogo+'">'+data.descripcion+'</option>';
    $("#catalogo").html(html_select);
    $(document).find("#catalogo").val(data.catalogo);
    $("#catalogo").trigger('chosen:updated');
    $(document).find("#cantidad").val(data.cantidad);
    $(document).find("#precio").val(data.precio);
    //llamar a la funcion eliminar sesiones
    eliminarsesion(data.catalogo);
    //quitar la fila de la tabla estableciendo el nuevo total temporal antes de la edición
    var tr     = $(e.target).parents("tr"),
    totaltotal  = $("#totalEnd");
    var totalFila=parseFloat(data.precio)*parseFloat(data.cantidad);
    monto_total = parseFloat(totaltotal.text()) - parseFloat(totalFila);
    tr.remove();
    $("#total").val(onFixed(monto_total,2));
    $("#pie #totalEnd").text(onFixed(monto_total,2));
  });

  $("#btnsubmit").on("click", function (e) {
      ////// obtener todos los datos y convertirlos a json /////////////////////////////////////////////
      if(total>monto){
        swal(
           '¡Aviso!',
           'El total supera al monto del proyecto',
           'warning'
         )
      }else{
        guardar_presupuesto();
      }

  });

  $("#guardarunidades").on("click",function(e){
      guardarunidades();
  });

  $("#guardarcatalogo").on("click",function(e){
      guardar_descripcion();
  });

  $("#btnlimpiar").on("click",function(e){
    var ruta = '../limpiarsesion';
    $.ajax({
        url: ruta,
        type:'get',
        dataType:'json',
        data: {},
       success : function(msj){
          if(msj.mensaje==='limpiado'){
            traersesion();
          }
        }
      });
  });

});

/// funcion para guardar los datos en una variable de sesion
function guardarsesion(dataJson){
  var datos = JSON.parse(dataJson);
  var token = $('meta[name="csrf-token"]').attr('content');
  var ruta = '../guardarsesion';
  $.ajax({
      url: ruta,
      headers: {'X-CSRF-TOKEN':token},
      type:'POST',
      dataType:'json',
      data: {catalogo:datos.catalogo,descripcion:datos.descripcion,cantidad:datos.cantidad,
        precio:datos.precio,unidad:datos.unidad},
     success : function(msj){
       console.log(msj);
          if (msj.mensaje==='error') {
            toastr.error('Ese elemento ya existe');
          }else{
            traersesion();
          }
      },
      error: function(error){
        console.log(error);
      }
    });
}
//funciones para traer la sesion y llenar la tabla
function traersesion(){
  $("#cuerpo").empty();
  $.ajax({
    url:'../traersesion',
    type:'get',
    data:{},
    success: function(data){
      $.each(data, function(index,value){
        if(value.existe==true){
          dataJson = JSON.stringify({ catalogo: parseInt(value.catalogo_id),descripcion: value.descripcion,cantidad:value.cantidad,precio:value.precio,unidad:value.unidad });
          llenar(dataJson);
        }
      });
    }
  });
}

function eliminarsesion(id)
{
  $.ajax({
    url: '../eliminarsesion/'+id,
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type:'DELETE',
    dataType:'json',
    data:{id},

    success: function(msj){
      console.log(msj);
    },
    error: function(data, textStatus, errorThrown){
      toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
    console.log(data);
    }
  });
}

function listarcatalogo(idp,idc){
  $.ajax({
    url:'../getcatalogo',
    type: 'get',
    data: {idp,idc},
    success: function(response){
      html_select += '<option value="">Seleccione un catalogo</option>';
      $.each(response,function(index,value){
        html_select +='<option data-unidad="'+value.unidad_medida+'" value="'+value.id+'">'+value.nombre+'</option>'
      });
      $("#catalogo").html(html_select);
      $("#catalogo").trigger('chosen:updated');
    }
  });
}

function listarunidades(){
  $.ajax({
    url: '../../presupuestos/getunidades',
    headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
    type: 'get',
    data:{},
    success: function(response){
      var html_select = '<option value="">Seleccione una unidad de medida</option>';
      $.each(response, function(index,value){
        html_select +='<option value="'+value.nombre_medida+'">'+value.nombre_medida+'</option>'
      });
      $("#txtunidad").html(html_select);
      $("#txtunidad").trigger('chosen:updated');
    },
    error: function(error){
      toastr.error('Ocurrio un error en la solicitud');
    }
  });
}

function guardar_descripcion()
{
    var nombre_descripcion = $("#txtdescripcion").val();
    var unidad_medida = $("#txtunidad").val();
    var categoria_id = $("#categoria_id").val();
    var nombre = nombre_descripcion.toUpperCase();
    var idpresupuesto = $("#presuid").val();
    var it=$("#itemid").val();
    var token = $('meta[name="csrf-token"]').attr('content');
    var ruta = '/'+carpeta()+'/public/presupuestos/guardardescripcion';
    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN':token},
        type:'POST',
        dataType:'json',
        data: {nombre,unidad_medida,categoria_id},
       success : function(msj){
            //window.location.href = "/sisverapaz/public/proyectos";
            console.log(msj.mensaje);
            if(msj.mensaje === "exito")
            {
                toastr.success('Catalogo registrado éxitosamente');
                $("#txtdescripcion").val("");
                $("#txtunidad").val("");
                listarcatalogo(idpresupuesto,it);
            }else{
                toastr.error('Ocurrió un error al guardar');
            }

        },
        error: function(data, textStatus, errorThrown){
            toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
            $.each(data.responseJSON.errors, function( key, value ) {
                toastr.error(value);
            });
        }
    });
}


function guardarunidades(){
  var unidad = $("#txtnombreunidades").val();
  var nombre_medida = unidad.toUpperCase();
  var token = $('meta[name="csrf-token"]').attr('content');
  var ruta = '../../unidadmedidas';
  $.ajax({
    url: ruta,
    headers: {'X-CSRF-TOKEN':token},
    type:'POST',
    dataType:'json',
    data: {nombre_medida},
    success : function(msj){
         //console.log(msj.mensaje);
         if(msj.mensaje === "exito")
         {
             toastr.success('Unidad de medida registrado éxitosamente');
             $("#txtnombreunidades").val("");
             listarunidades();
             $("#txtunidad").trigger('chosen:updated');
         }else{
             toastr.error('Ocurrió un error al guardar');
         }

     },
     error: function(data, textStatus, errorThrown){
         toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
         $.each(data.responseJSON.errors, function( key, value ) {
             toastr.error(value);
         });
     }
  });
}


/*function onFixed (valor, maximum) {
    maximum = (!maximum) ? 2 : maximum;
    return valor.toFixed(maximum);
}*/

function clearForm () {
    $("#presupuestodetalle").find("#precio,#cantidad").each(function (index, element) {
        $(element).val("");
    });
}

function quitar_mostrar (ID) {
    $("#catalogo option").each(function (index, element) {
      if($(element).attr("value") == ID ){
        $(element).css("display", "block");
      }
    });
    $("#catalogo").trigger('chosen:updated');
  }

  function guardar_presupuesto(){
    var ruta = "../../presupuestodetalles";
    var token = $('meta[name="csrf-token"]').attr('content');
    var total = $("#total").val();
    var presupuesto_id = $("#presuid").val();
    var presupuestos = new Array();
    $(cuerpo).find("tr").each(function (index, element) {
        if(element){
            presupuestos.push({
                catalogo: $(element).attr("data-catalogo"),
                cantidad :$(element).attr("data-cantidad"),
                precio : $(element).attr("data-precio")
            });
        }
    });
    console.log(presupuestos);


/////////////////////////////////////////////////// funcion ajax para guardar ///////////////////////////////////////////////////////////////////
      $.ajax({
          url: ruta,
          headers: {'X-CSRF-TOKEN':token},
          type:'POST',
          dataType:'json',
          data: {presupuesto_id,total,presupuestos},
         success : function(msj){
           console.log(msj);
           if(msj.mensaje==='exito'){
             window.location.href = "../../presupuestos/"+msj.id;
             toastr.success('Presupuesto registrado éxitosamente');
           }else{
             toastr.error('A ocurrido un error, contacte al administrador');
           }
          },
          error: function(data, textStatus, errorThrown){
              toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
              $.each(data.responseJSON.errors, function( key, value ) {
                  toastr.error(value);
          });
          }
    });
  }

  // funciones llenar
  function llenar(dataJson){
    var datos = JSON.parse(dataJson);
    var subtotal=0.0;
    subtotal = parseFloat(datos.precio) * parseFloat(datos.cantidad);
    monto_total=monto_total+subtotal;
    $(tbMaterial).append(
        "<tr data-catalogo='"+datos.catalogo+"' data-cantidad='"+datos.cantidad+"' data-precio='"+datos.precio+"' >"+
            "<td>" + datos.descripcion + "</td>" +
            "<td>" + datos.unidad + "</td>" +
            "<td>" + datos.cantidad+ "</td>" +
            "<td> $" + datos.precio + "</td>" +
            "<td> $" + onFixed( datos.cantidad*datos.precio, 2 ) + "</td>" +
            "<td>"+
            "<div class='btn-group'>"+
            "<button data-data="+dataJson+" type='button' id='edit-btn' class='btn btn-warning btn-xs'><span class='glyphicon glyphicon-edit'></span></button>"+
            "<button type='button' data-data="+dataJson+" id='delete-btn' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-remove'></span></button>"+
            "</div>"+
            "</td>" +
        "</tr>"
    );
    $("#total").val(onFixed(monto_total,2));
    $("#pie #totalEnd").text(onFixed(monto_total,2));
  }
