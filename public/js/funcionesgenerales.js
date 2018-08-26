//funciones dentro del document

      $(document).ready(function () {


          //datatables
          var tabla = $('#example2').DataTable({
              language: {
                  processing: "Búsqueda en curso...",
                  search: "Búscar:",
                  lengthMenu: "Mostrar _MENU_ Elementos",
                  info: "Mostrando _START_ de _END_ de un total de _TOTAL_ elementos",
                  infoEmpty: "Visualizando 0 de 0 de un total de 0 elementos",
                  infoFiltered: "(Filtrado de _MAX_ elementos en total)",
                  infoPostFix: "",
                  loadingRecords: "Carga de datos en proceso..",
                  zeroRecords: "Elementos no encontrados",
                  emptyTable: "La tabla no contiene datos",
                  paginate: {
                      first: "Primero",
                      previous: "Anterior",
                      next: "siguiente",
                      last: "Último"
                  },
              },
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": false,
              "info": true,
              "autoWidth": false
          });

          var consulta = $('#consulta').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdf'

                },
                {
                    extend: 'excel'

                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ],
            columnDefs: [ {
                targets: -1,
                visible: false
            } ],
              language: {
                  processing: "Búsqueda en curso...",
                  search: "Búscar:",
                  lengthMenu: "Mostrar _MENU_ Elementos",
                  info: "Mostrando _START_ de _END_ de un total de _TOTAL_ Elementos",
                  infoEmpty: "Visualizando 0 de 0 de un total de 0 elementos",
                  infoFiltered: "(Filtrado de _MAX_ elementos en total)",
                  infoPostFix: "",
                  loadingRecords: "Carga de datos en proceso..",
                  zeroRecords: "Elementos no encontrado",
                  emptyTable: "La tabla no contiene datos",
                  paginate: {
                      first: "Primero",
                      previous: "Anterior",
                      next: "siguiente",
                      last: "Último"
                  },
              },
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false
          });

          var register = $("#form-register");
              register.steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
              });

          //fechas
            var start = new Date(),
          	end = new Date(),
          	start2, end2;
            end.setDate(end.getDate() + 365);

              //para seleccionar una fecha de nacimiento mayor de 18 años
              $('.nacimiento').datepicker({
          	     selectOtherMonths: true,
                 changeMonth: true,
                 changeYear: true,
                 dateFormat: 'dd-mm-yy',
                 minDate: "-60Y",
                 maxDate: "-18Y",
    				     format: 'dd-mm-yyyy'
    		         });

                 $('.unafecha').datepicker({
             	     selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'dd-mm-yy',
                    minDate: start,
       				     format: 'dd-mm-yyyy'
       		         });

    /// establecer un periodo de tiempo
                 $("#fecha_inicio").datepicker({
                   selectOtherMonths: true,
                   changeMonth: true,
                   changeYear: true,
                   dateFormat: 'dd-mm-yy',
                   minDate: start,
                   maxDate: end,
               	onSelect: function(){
               		start2 = $(this).datepicker("getDate");
               		end2 = $(this).datepicker("getDate");

               		start2.setDate(start2.getDate() + 1);
               		end2.setDate(end2.getDate() + 365);

               		$("#fecha_fin").datepicker({
                           selectOtherMonths: true,
                           changeMonth: true,
                           changeYear: true,
                           dateFormat: 'dd-mm-yy',
                           minDate: start2,
                           maxDate: end2
               		});
               	}
               });

      //activar las mascaras
      $("[data-mask]").inputmask();

      //activar el chosen select
      var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"100%"}
      }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }

    //formulario de configuracion
    $("#form-configuracion").steps({
      headerTag: "h3",
      bodyTag: "section",
      transitionEffect: "slideLeft",
      stepsOrientation: "vertical",
      enableAllSteps: true,
      enablePagination: false
    });


});
// funcion para detectar la url del proyecto
function carpeta(){
      var carpeta = window.location.href;
      var nombre = carpeta.split("/");
      return nombre[3];
    }

//cambiarle idioma a datepicker
$.datepicker.regional['es'] = {
closeText: 'Cerrar',
prevText: '< Ant',
nextText: 'Sig >',
currentText: 'Hoy',
monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
weekHeader: 'Sm',
dateFormat: 'dd-mm-yyyy',
firstDay: 1,
isRTL: false,
showMonthAfterYear: false,
yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['es']);

//funcion para dar de baja
function baja(id,ruta)
  {
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
          var dominio = window.location.host;
          var form = $(this).parents('form');
          $('#baja').attr('action','http://'+dominio+'/'+carpeta()+'/public/'+ruta+'/baja/'+id+'+'+result.value);
          //document.getElmentById('baja').submit();
          $('#baja').submit();
          swal({
            type: 'success',
            title: 'Solicitud finalizada',
            html: 'Motivo: ' + result.value
          })
        }
      })
  }

//funcion para dar de alta
  function alta(id,ruta)
  {
      swal({
          title: 'Dar de alta',
          showCancelButton: true,
          confirmButtonText: 'Dar de alta',
          showLoaderOnConfirm: true,
          allowOutsideClick: false
      }).then(function () {
          var dominio = window.location.host;
          var form = $(this).parents('form');
          $('#alta').attr('action','http://'+dominio+'/'+carpeta()+'/public/'+ruta+'/alta/'+id);
          //document.getElmentById('baja').submit();
          $('#alta').submit();
          swal({
              type: 'success',
              title: 'Se dio de alta',
              html: ''
          })
      })
  }
// Funciones para el empleado guardar y limpiar
function guardarEmp()
{
  var nombre = $("#nom_empleado").val();
  var dui = $("#dui_empleado").val();
  var nit = $("#nit_empleado").val();
  var sexo = $('input:radio[name=sexo]:checked').val()
  var telefono_fijo = $("#fijo_empleado").val();
  var celular = $("#cel_empleado").val();
  var direccion = $("#dir_empleado").val();
  var fecha_nacimiento = $("#fecha_nacimiento").val();
  var num_cuenta = $("#cuenta_empleado").val();
  var num_contribuyente = $("#contri_empleado").val();
  var num_seguro_social =$("#seguro_empleado").val();
  var num_afp =$("#afp_empleado").val();
  var ruta ="/"+carpeta()+"/public/empleados";
  var token = $('meta[name="csrf-token"]').attr('content');

  $.ajax({
    url: ruta,
    headers: {'X-CSRF-TOKEN':token},
    type: 'POST',
    dataType: 'json',
    data:{nombre,dui,nit,sexo,telefono_fijo,celular,direccion,fecha_nacimiento,num_cuenta,num_contribuyente,num_seguro_social,num_afp},

    success: function(msj){
      if(msj.mensaje=="exito"){
        toastr.success('Empleado Registrado con éxito');
        limpiarEmpleado();
      }else{
        toastr.error('Ocurrió un error contante al administrador');
      }
    },
    error: function(data, textStatus, errorThrown){
      toastr.error('Ha ocurrido un '+textStatus+' en la solucitud');
      $.each(data.responseJSON.errors, function( key, value ) {
        toastr.error(value);
    });
    }
  });

return 1;
}

function limpiarEmpleado()
{
  $("#nom_empleado").val("");
  $("#dui_empleado").val("");
  $("#nit_empleado").val("");
  $('input:radio[name=sexo]').attr('checked',false);
  $("#fijo_empleado").val("");
  $("#cel_empleado").val("");
  $("#dir_empleado").val("");
  $("#fecha_nacimiento").val("");
  $("#cuenta_empleado").val("");
  $("#contri_empleado").val("");
  $("#seguro_empleado").val("");
  $("#afp_empleado").val("");
}

function fecha_espaniol(fechita){
  var fecha = new Date(fechita);
  var options = { weekday: "long", year: 'numeric', month: 'long', day: 'numeric' };

  return fecha.toLocaleDateString("es-ES", options);
}

function decodificar(data){
  //decodifica la información
  var datadecodificada = window.atob(data);
  //convertir los datos decodificados a formato JSON
  var datos = JSON.parse(datadecodificada);
  return datos;
}

//funcion que formatea los valores enteros a 2 decimales
function onFixed (valor, maximum) {
  maximum = (!maximum) ? 2 : maximum;
  return valor.toFixed(maximum);
}
