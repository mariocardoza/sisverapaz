var contador_monto=0;
var monto_total = 0.0;
var monto = 0.0;
$(document).ready(function(){

  cargarFondos();


$('#btnAgregar').on("click", function(e){
    e.preventDefault();
    var id = $("#idp").val();
    var cat = $("#cat_id").val() || 0;
    var cat_nombre = $("#cat_id option:selected").text() || 0;
    var cant_monto = $("#cant_monto").val() || 0;
    var existe = $("#cat_id option:selected");

    if(cat && cant_monto){
      monto+=parseFloat(cant_monto);
      addbase(id,cat,cant_monto);
      contador_monto++;
      $(tbFondos).append(
                 "<tr data-categoria='"+cat+"' data-monto='"+cant_monto+"'>"+
                     "<td>" + cat_nombre + "</td>" +
                     "<td>" + onFixed( parseFloat(cant_monto), 2 ) + "</td>" +
                     "<td><button type='button' id='delete-btn' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></button></td>" +
                 "</tr>"
             );
      monto_total=monto;
      $("#monto").val(onFixed(monto_total));
      $("#contador_fondos").val(contador_monto);
      $("#pie_monto #totalEnd").text(onFixed(monto));
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

//Agrega los montos a la tabla de fondos y actualiza el monto total
  $('#btnAgregarfondo').on("click", function(e){
    e.preventDefault();
    var cat = $("#cat_id").val() || 0;
    var cat_nombre = $("#cat_id option:selected").text() || 0;
    var cant_monto = $("#cant_monto").val() || 0;
    var existe = $("#cat_id option:selected");

    if(cat && cant_monto){
      monto+=parseFloat(cant_monto);
      contador_monto++;
      $(tbFondos).append(
                 "<tr data-categoria='"+cat+"' data-monto='"+cant_monto+"'>"+
                     "<td>" + cat_nombre + "</td>" +
                     "<td>" + onFixed( parseFloat(cant_monto), 2 ) + "</td>" +
                     "<td><button type='button' id='delete-btn' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></button></td>" +
                 "</tr>"
             );
      monto_total=monto;
      $("#monto").val(onFixed(monto_total));
      $("#contador_fondos").val(contador_monto);
      $("#pie_monto #totalEnd").text(onFixed(monto));
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

  $("#verfondos").on("click", function(ev){
    $("#cuerpo_fondos").empty();
    var idp= $("#idp").val();
    //var monto_total=$("#monto").val();
    cargarFondos();
    var datos = $.get('/'+carpeta()+'/public/proyectos/getMontos/'+ idp , function(data){
      for(var i=0;i<data.length;i++){
        var dataJson = JSON.stringify({ id: data[i].fondocat.id, monto: data[i].monto })
        monto+= parseFloat(data[i].monto);
        $(tbFondos).append(
                 "<tr data-categoria='"+data[i].id+"' data-monto='"+data[i].monto+"'>"+
                     "<td>" + data[i].fondocat.categoria + "</td>" +
                     "<td>" + onFixed(parseFloat(data[i].monto),2) + "</td>" +
                     "<td class='btn-group'><button type='button' id='delete-from-base' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></button>" +
                     "<button data-data="+ dataJson +"  type='button' id='edit-form' class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-edit'></button></td>" +
                 "</tr>"
          );
    }
    monto_total=monto;
      $("#pie_monto #totalEnd").text(onFixed(parseFloat(monto),2));
      //$(existe).css("display", "none");
    });

  });


//agrega nueva categoria de los montos para luego seleccionarla
    $('#guardarcategoria').on("click", function(e){
    var cate = $("#cate").val();
    var categoria = cate.toUpperCase();
    var ruta = "guardarcategoria";
    var token = $('meta[name="csrf-token"]').attr('content');
    //alert(nombre);
    $.ajax({
      url: ruta,
      headers: {'X-CSRF-TOKEN':token},
      type:'POST',
      dataType:'json',
      data:{categoria},

      success: function(){
        toastr.success('categoria creado éxitosamente');
        $("#cate").val("");
        cargarFondos();
        $("#cat_id").trigger('chosen:updated');
        $("#btncategoria").modal("hide");
      },
      error : function(data){
          toastr.error(data.responseJSON.errors.categoria);
        }
    });
  });

  $('#btnsubmit').on("click", function(e){
    var ruta = "../proyectos";
    var token = $('meta[name="csrf-token"]').attr('content');
    var tot=0.0;
    var montos = new Array();
    var montosorg = new Array();
    var nombre = $("#nombre").val();
    var monto = $("#monto").val();
    var direccion = $("#direccion").val();
    var motivo = $("#motivo").val();
    var fecha_inicio = $("#fecha_inicio").val();
    var fecha_fin = $("#fecha_fin").val();
    var beneficiarios = $("#beneficiarios").val();
    $(cuerpo_fondos).find("tr").each(function (index, element) {
      if(element){
        montos.push({
          categoria : $(element).attr("data-categoria"),
          monto : $(element).attr("data-monto")
        });
      }
    });
    console.log(montos);
    $.ajax({
      url: ruta,
      headers: {'X-CSRF-TOKEN':token},
      type:'POST',
      dataType:'json',
      data:{nombre,monto,motivo,direccion,fecha_inicio,fecha_fin,beneficiarios,montos,montosorg},

      success: function(msj){
        window.location.href = "proyectos";
        console.log(msj);
        toastr.success('Proyecto creado éxitosamente');
      },
      error: function(data, textStatus, errorThrown){
        console.log(data);
				toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
				$.each(data.responseJSON.errors, function( key, value ) {
					toastr.error(value);
			});
			}
    });
  });


//elimina un elemento de la tabla temporal de fondos y actualiza el monto total
  $(document).on("click", "#delete-btn", function (e) {
        var tr     = $(e.target).parents("tr"),
            totaltotal  = $("#totalEnd");
        var totalFila=parseFloat($(this).parents('tr').find('td:eq(1)').text());
        monto = parseFloat(totaltotal.text()) - parseFloat(totalFila);
        monto_total=monto_total-parseFloat(totalFila);
        quitar_mostrar($(tr).attr("data-categoria"));
        tr.remove();
        $("#monto").val(onFixed(monto_total));
        $("#pie_monto #totalEnd").text(onFixed(monto));
        contador_monto--;
        $("#contador_fondos").val(contador_monto);
  });

    $(document).on("click", "#delete-from-base", function (e) {
        var tr     = $(e.target).parents("tr"),
            totaltotal  = $("#totalEnd");
        var id = $(this).parents('tr').find('td:eq(0)').text();
        var totalFila=parseFloat($(this).parents('tr').find('td:eq(1)').text());
        monto = parseFloat(totaltotal.text()) - parseFloat(totalFila);
        monto_total=monto_total-parseFloat(totalFila);
        deletebase(id);
        quitar_mostrar($(tr).attr("data-categoria"));
        tr.remove();
        $("#monto").val(onFixed(monto_total));
        $("#pie_monto #totalEnd").text(onFixed(monto));
        contador_monto--;
        $("#contador_fondos").val(contador_monto);
  });

  $(document).on("click", "#edit-form", function (e) {
    var data = JSON.parse($(e.currentTarget).attr('data-data'));
    $(document).find("#cat_id").val(data.id)
    $(document).find("#cant_monto").val(data.monto);
  });

});

//funcion que formatea los valores enteros a 2 decimales
function onFixed (valor, maximum) {
  maximum = (!maximum) ? 2 : maximum;
  return valor.toFixed(maximum);
}

function cargarFondos(){
  $.get('listarfondos', function (data){
    var html_select = '<option value="">Seleccione una categoria</option>';
    for(var i=0;i<data.length;i++){
      html_select +='<option value="'+data[i].id+'">'+data[i].categoria+'</option>'
      //console.log(data[i]);
      $("#cat_id").html(html_select);
      $("#cat_id").trigger('chosen:updated');
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

  function deletebase(id)
  {
    $.ajax({
      url: '/'+carpeta()+'/public/proyectos/deleteMonto/'+id,
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
      url: '/'+carpeta()+'/public/proyectos/addMonto',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type:'POST',
      dataType:'json',
      data:{id,cat,monto},

      success: function(msj){
        //window.location.href = "/sisverapaz/public/proyectos";
        console.log(msj);
        toastr.success('Monto agregado éxitosamente');
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
