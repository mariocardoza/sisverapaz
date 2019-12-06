var monto_total = 0.0;
var idp= $("#idp").val();
var html_select = '';
var dataJson;
var dat = new Array();
var token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(e){
  cargarFondos(idp);


  $("#verfondos").on("click", function(ev){
    $("#cuerpo_fondos").empty();
    monto_total=0.0;
    getsesion();
  });

  $("#limpiar").on("click", function(e){
    window.history.back();
  });

  $('#btnAgregar').on("click", function(e){
      e.preventDefault();
      var id = $("#idp").val();
      var cat = $("#cat_id").val() || 0;
      var cat_nombre = $("#cat_id option:selected").text() || 0;
      var cant_monto = $("#cant_monto").val() || 0;
      var existe = $("#cat_id option:selected");
      var texto=cat_nombre.replace(" ","_");
      dataJson = JSON.stringify({ id: parseInt(cat),categoria: texto, monto: parseFloat(cant_monto) })

      if(cat && cant_monto){
        sesion(dataJson);
        llenar(dataJson);
        $(existe).css("display", "none");
        $("#cant_monto").val("");
        $("#cat_id").val("");
        $("#cat_id").trigger('chosen:updated');
      }else{
         swal(
                '¡Aviso!',
                'Debe seleccionar una categoría y digitar el monto',
                'warning'
              )
      }
    });

    //agrega nueva categoria de los montos para luego seleccionarla
        $('#guardarcategoria').on("click", function(e){
        var cate = $("#cate").val();
        var categoria = cate.toUpperCase();
        var ruta = "../guardarcategoria";
        $.ajax({
          url: ruta,
          headers: {'X-CSRF-TOKEN':token},
          type:'POST',
          dataType:'json',
          data:{categoria},

          success: function(response){
            console.log(response);
            if(response.mensaje === 'exito'){
              toastr.success('categoria creado éxitosamente');
              html_select += '<option value="'+response.datos.id+'">'+response.datos.categoria+'</option>';
            }else{
              toastr.error('Ocurrió un error en la solicitud, contacte al administrador');
            }
            $("#cate").val("");
            $("#cat_id").html(html_select);
            $("#cat_id").trigger('chosen:updated');
            $("#modalcategoria").modal("hide");
          },
          error : function(data){
              toastr.error(data.responseJSON.errors.categoria);
            }
        });
      });


    $(document).on("click", "#delete-from-base", function (e) {
        var tr     = $(e.target).parents("tr"),
            totaltotal  = $("#totalEnd");
        var totalFila=parseFloat($(this).parents('tr').find('td:eq(1)').text());
        console.log(totalFila);
        monto_total=monto_total-parseFloat(totalFila);
        var data = JSON.parse($(e.currentTarget).attr('data-data'));
        deletebase(data.id);
        quitar_mostrar($(tr).attr("data-categoria"));
        tr.remove();
        $("#monto").val(onFixed(monto_total));
        $("#pie_monto #totalEnd").text(onFixed(monto_total));
  });

  $(document).on("click", "#edit-form", function (e) {
    var data = JSON.parse($(e.currentTarget).attr('data-data'));
    var tot= parseFloat(data.monto);
    monto_total=monto_total-tot;
    console.log(monto_total);
    deletebase(data.id);
    $("#pie_monto #totalEnd").text(onFixed(parseFloat(monto_total),2));
    $("#monto").val(onFixed(monto_total,2));
    html_select += '<option value="'+data.id+'">'+data.categoria+'</option>';
    $("#cat_id").html(html_select);
    $(document).find("#cat_id").val(data.id)
    $("#cat_id").trigger('chosen:updated');
    $(document).find("#cant_monto").val(data.monto);
    var tr = $(e.target).parents("tr");
    tr.remove();
  });


});

function cargarFondos(id){
  $.ajax({
    url:'../listarfondos',
    type:'get',
    data:{id},
    success: function(response){
      html_select += '<option value="">Seleccione una categoria</option>';
      $.each(response, function( key, value ) {
        html_select +='<option value="'+value.id+'">'+value.categoria+'</option>'
      });
      $("#cat_id").html(html_select);
      $("#cat_id").trigger('chosen:updated');
    }
  });
}

function getsesion(){
  $.ajax({
    url:'../getsesion',
    type:'get',
    data:{},
    success:function(data){
      for(var i=0;i<data.length;i++){
        if(data[i].existe===true){
          dataJson = JSON.stringify({ id: parseInt(data[i].cat_id),categoria: data[i].categoria, monto: data[i].monto })
          llenar(dataJson);
        }
      }
    },
    error: function(error){

    }
  });
}

function deletebase(id)
{
  $.ajax({
    url: '../deleteMonto/'+id,
    headers: {'X-CSRF-TOKEN': token},
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

function quitar_mostrar (ID) {
    $("#cat_id option").each(function (index, element) {
      if($(element).attr("value") == ID ){
        $(element).css("display", "block");
      }
    });
    $("#cat_id").trigger('chosen:updated');
  }

  function llenar(dataJson){
    var datos = JSON.parse(dataJson);

    monto_total+= parseFloat(datos.monto);
    $(tbFondos).append(
             "<tr data-categoria='"+datos.id+"' data-monto='"+datos.monto+"'>"+
                 "<td>" + datos.categoria + "</td>" +
                 "<td>" + onFixed(parseFloat(datos.monto),2) + "</td>" +
                 "<td class='btn-group'><button type='button' data-data="+ dataJson +" id='delete-from-base' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></button>" +
                 "<button data-data="+ dataJson +" type='button' id='edit-form' class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-edit'></button></td>" +
             "</tr>"
      );
      $("#pie_monto #totalEnd").text(onFixed(parseFloat(monto_total),2));
      $("#monto").val(onFixed(parseFloat(monto_total),2));
  }

  function sesion(dataJson){
    var datos = JSON.parse(dataJson);
    var ruta = '../sesion';
    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN':token},
        type:'POST',
        dataType:'json',
        data: {cat_id:parseInt(datos.id),categoria:datos.categoria,monto:parseFloat(datos.monto)},
       success : function(msj){
            console.log(msj);
        }
      });
  }
