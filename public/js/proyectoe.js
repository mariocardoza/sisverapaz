var contador_monto=0;
var monto_total = 0.0;
var idp= $("#idp").val();
var html_select = '';
var dataJson;
$(document).ready(function(e){
  cargarFondose(idp);


  $("#verfondos").on("click", function(ev){
    $("#cuerpo_fondos").empty();

    var datos = $.get('../getMontos/'+ idp , function(data){
      for(var i=0;i<data.length;i++){
        var text = data[i].fondocat.categoria;
        var texto=text.replace(" ","_");
        dataJson = JSON.stringify({ id: data[i].fondocat.id,categoria: texto.trim(), monto: data[i].monto })
        //sesion(dataJson);
        getsesion();

        llenar(dataJson);
        monto_total=monto_total+data[i].monto;
    }

      $("#pie_monto #totalEnd").text(onFixed(parseFloat(monto_total),2));
    });
  });

  $("#limpiar").on("click", function(e){
    var token = $('meta[name="csrf-token"]').attr('content');
    var ruta = '../limpiarsesion';
    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN':token},
        type:'get',
        dataType:'json',
        data: {},
       success : function(msj){
            console.log(msj);
        }
      });
  });

  $('#btnAgregar').on("click", function(e){
      e.preventDefault();
      var id = $("#idp").val();
      var cat = $("#cat_id").val() || 0;
      var cat_nombre = $("#cat_id option:selected").text() || 0;
      var cant_monto = $("#cant_monto").val() || 0;
      var existe = $("#cat_id option:selected");
      var text = cat_nombre;
      var texto=text.replace(" ","_");
      dataJson = JSON.stringify({ id: parseInt(cat),categoria: texto, monto: parseFloat(cant_monto) })


      if(cat && cant_monto){
        monto_total=monto_total+=parseFloat(cant_monto);
        sesion(dataJson);
        llenar(dataJson);

        $("#pie_monto #totalEnd").text(onFixed(parseFloat(monto_total),2));
        $("#monto").val(onFixed(monto_total));
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


    $(document).on("click", "#delete-from-base", function (e) {
        var tr     = $(e.target).parents("tr"),
            totaltotal  = $("#totalEnd");
        var id = $(this).parents('tr').find('td:eq(0)').text();
        var totalFila=parseFloat($(this).parents('tr').find('td:eq(1)').text());
        monto = parseFloat(totaltotal.text()) - parseFloat(totalFila);
        monto_total=monto_total-parseFloat(totalFila);
        var data = JSON.parse($(e.currentTarget).attr('data-data'));
        deletebase(data.id);
        quitar_mostrar($(tr).attr("data-categoria"));
        tr.remove();
        $("#monto").val(onFixed(monto_total));
        $("#pie_monto #totalEnd").text(onFixed(monto));
        contador_monto--;
        $("#contador_fondos").val(contador_monto);
  });

  $(document).on("click", "#edit-form", function (e) {
    var data = JSON.parse($(e.currentTarget).attr('data-data'));
    var tot= parseFloat(data.monto);
    monto_total=monto_total-tot;
    $("#pie_monto #totalEnd").text(onFixed(parseFloat(monto_total),2));
    html_select += '<option value="'+data.id+'">'+data.categoria+'</option>';
    $("#cat_id").html(html_select);
    $(document).find("#cat_id").val(data.id)
    $("#cat_id").trigger('chosen:updated');
    $(document).find("#cant_monto").val(data.monto);
    var tr = $(e.target).parents("tr");
    tr.remove();
  });


});

function cargarFondose(id){
  $.get('../listarfondose/'+id, function (data){
    html_select += '<option value="">Seleccione una categoria</option>';
    for(var i=0;i<data.length;i++){
      html_select +='<option value="'+data[i].id+'">'+data[i].categoria+'</option>'
      //console.log(data[i]);
      $("#cat_id").html(html_select);
      $("#cat_id").trigger('chosen:updated');
    }
  });
}

function getsesion(){
  $.get('../getsesion', function (data){
    for(var i=0;i<data.length;i++){
      dataJson = JSON.stringify({ id: parseInt(data[i].cat_id),categoria: data[i].categoria, monto: data[i].monto })

      llenar(dataJson);
    }
  });

}

function deletebase(id)
{
  $.ajax({
    url: '../deleteMonto/'+id,
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type:'DELETE',
    dataType:'json',
    data:{id},

    success: function(msj){
      //window.location.href = "/sisverapaz/public/proyectos";
      console.log(msj);
      toastr.success('Monto eliminado éxitosamente');
    },
    error: function(data, textStatus, errorThrown){
      toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
      /*$.each(data.responseJSON.errors, function( key, value ) {
        toastr.error(value);
    });*/
    console.log(data);
    }
  });
}

function addbase(id,cat,monto)
{
  $.ajax({
    url: 'addMonto',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type:'POST',
    dataType:'json',
    data:{id,cat,monto},

    success: function(msj){
      console.log(msj);
      toastr.success('Monto agregado éxitosamente');
    },
    error: function(data, textStatus, errorThrown){
      toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
      $.each(data.responseJSON.errors, function( key, value ) {
        toastr.error(value);
    });
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


    monto+= parseFloat(datos.monto);
    $(tbFondos).append(
             "<tr data-categoria='"+datos.id+"' data-monto='"+datos.monto+"'>"+
                 "<td>" + datos.categoria + "</td>" +
                 "<td>" + onFixed(parseFloat(datos.monto),2) + "</td>" +
                 "<td class='btn-group'><button type='button' data-data="+ dataJson +" id='delete-from-base' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></button>" +
                 "<button data-data="+ dataJson +"  type='button' id='edit-form' class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-edit'></button></td>" +
             "</tr>"
      );
  }

  function sesion(dataJson){
    var datos = JSON.parse(dataJson);
    var token = $('meta[name="csrf-token"]').attr('content');
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
