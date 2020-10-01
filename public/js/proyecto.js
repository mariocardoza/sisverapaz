var contador_monto=0;
var monto_total = 0.0;
var monto = 0.0;
var marker;          //variable del marcador
var coords = {};    //coordenadas obtenidas con la geolocalización
$(document).ready(function(){

  cargarFondos();
  initMap();

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




//agrega nueva categoria de los montos para luego seleccionarla
    $('#guardarcategoria').on("click", function(e){
    var cate = $("#cate").val();
    var categoria = cate.toUpperCase();
    var ruta = "guardarcategoria";
    var token = $('meta[name="csrf-token"]').attr('content');

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
        $("#modalcategoria").modal("hide");
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
    var monto_desarrollo = $("#monto_desarrollo").val();
    var lng=$("#lng").val();
    var lat=$("#lat").val();
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
      data:{nombre,monto,motivo,direccion,monto_desarrollo,fecha_inicio,fecha_fin,beneficiarios,montos,montosorg,lng,lat},

      success: function(msj){
        console.log(msj);
        if(msj[0]==1){
          window.location.href = "../proyectos";
          toastr.success('Proyecto creado éxitosamente');
        }else{
          toastr.error("Ocurrió un error");
        }
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

  $(document).on("click","#cat_id",function(e){
    e.preventDefault();
    console.log("aqui");
    cargarFondos();
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

});



function cargarFondos(){
  modal_cargando();
  $.ajax({
    url:'listarfondos',
    type:'get',
    data:{},
    success: function(data){
      swal.closeModal();
      var html_select = '<option value="">Seleccione una categoria</option>';
      for(var i=0;i<data.length;i++){
        html_select +='<option value="'+data[i].id+'">'+data[i].nombre+'</option>'
        //console.log(data[i]);
        $("#cat_id").html(html_select);
        $("#cat_id").trigger('chosen:updated');
      }
    },error: function(error){
      swal.closeModal();
      toastr.error("Ocurrió un error");
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


/*function initMap() {
var map;
   
    map = new google.maps.Map(document.getElementById('mapita'), {
      center: {lat: 13.6445855, lng: -88.8731913},
      zoom: 15,   
    });

    var marker = new google.maps.Marker({
        position: {lat: 13.6445855, lng: -88.8731913},
        map: map,
        title: 'Verapaz',
    });

}*/

//Funcion principal
initMap = function () 
{
  var lng= -88.87197894152527;
  var lat= 13.643449058476703;
    //usamos la API para geolocalizar el usuario
        /*navigator.geolocation.getCurrentPosition(
          function (position){*/
            coords =  {
              lng: -88.87197894152527,
              lat: 13.643449058476703
            };
            setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
            
           
          /*},function(error){console.log(error);});
          */
         
    
}



function setMapa (coords)
{   
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('mapita'),
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
        icon: '../img/obrero.png', // Path al nuevo icono,
      });
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);
      
      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("lat").value = this.getPosition().lat();
        document.getElementById("lng").value = this.getPosition().lng();
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
