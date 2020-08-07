$(document).ready(function(e){
    $(document).on("click","#subir_contrato", function(e){
        e.preventDefault();
        $("#modal_subir_contrato").modal("show");
    });

    $(document).on("click","#add_oferta", function(e){
      e.preventDefault();
      $("#modal_subir_oferta").modal("show");
  });

    $(document).on('submit','#form_subircontrato', function(e) {
            // evito que propague el submit
            e.preventDefault();
            modal_cargando();
            // agrego la data del form a formData
            var formData = new FormData(this);
            formData.append('_token', $('input[name=_token]').val());
          
            $.ajax({
                type:'POST',
                url:'../proyectos/subircontrato',
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    if(data[0]==1){
                      toastr.success("Contrato subido con exito");
                      contratos(data[2]);
                      informacion(elid);
                      $("#modal_subir_contrato").modal("hide");
                      $("#form_subircontrato").trigger("reset");
                      swal.closeModal();
                    }
                },
                error: function(error){
                    swal.closeModal();
                  $.each(error.responseJSON.errors, function( key, value ) {
                    toastr.error(value);
                    swal.closeModal();
                  });
                }
            });
    });

    $(document).on('submit','#form_subiroferta', function(e) {
      // evito que propague el submit
      e.preventDefault();
      modal_cargando();
      // agrego la data del form a formData
      var formData = new FormData(this);
      formData.append('_token', $('input[name=_token]').val());
    
      $.ajax({
          type:'POST',
          url:'../proyectos/subiroferta',
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(data){
              if(data[0]==1){
                toastr.success("Oferta subida con exito");
                licitacion(data[2]);
                informacion(elid);
                $("#modal_subir_oferta").modal("hide");
                $("#form_subiroferta").trigger("reset");
                $(".chosen-select-width").trigger("chosen:updated");
                $("#info5").text("");
                swal.closeModal();
              }
          },
          error: function(error){
              swal.closeModal();
            $.each(error.responseJSON.errors, function( key, value ) {
              toastr.error(value);
              swal.closeModal();
            });
          }
      });
    });

    $(document).on('submit','#form_subirbase', function(e) {
      // evito que propague el submit
      e.preventDefault();
      modal_cargando();
      // agrego la data del form a formData
      var formData = new FormData(this);
      formData.append('_token', $('input[name=_token]').val());
    
      $.ajax({
          type:'POST',
          url:'../proyectos/subirbase',
          data:formData,
          cache:false,
          contentType: false,
          processData: false,
          success:function(data){
              if(data[0]==1){
                toastr.success("Base de licitación subida con éxito");
                licitacion(data[2]);
                informacion(elid);
                $("#modal_subir_base").modal("hide");
                $("#form_subirbase").trigger("reset");
                
                $("#info6").text("");
                swal.closeModal();
              }
          },
          error: function(error){
              swal.closeModal();
            $.each(error.responseJSON.errors, function( key, value ) {
              toastr.error(value);
              swal.closeModal();
            });
          }
      });
    });

    $(document).on("click","#eli_acti", function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
        title: 'Actividad',
        text: "¿Está seguro de eliminar la actividad?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si!',
        cancelButtonText: '¡No!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url:'../calendarizaciones/'+id,
            type:'delete',
            dataType:'json',
            
            success: function(json){
              if(json[0]==1){
                
                toastr.success("Actividad eliminada con éxito");
                calendario(elid);
              }else{
                toastr.error("Ocurrió un error");
              }
            }, error: function(error){

            }
          });
          /*swal(
            '¡Éxito!',
            'Materiales ya en posesión del encargando',
            'success'
          );*/
        } else if (result.dismiss === swal.DismissReason.cancel) {
          swal(
            'Operación cancelada',
            
          );
        }
      });
    });

  //funcion para quitar una oferta
  $(document).on("click","#quitar_oferta",function(e){
    var id=$(this).attr("data-id");
    swal({
      title: 'Eliminar la oferta',
      text: "¿Está seguro de eliminar esta oferta?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '¡Si!',
      cancelButtonText: '¡No!',
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      buttonsStyling: false,
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url:'../proyectos/borrarlicitacion/'+id,
          type:'get',
          dataType:'json',
          success: function(json){
            if(json[0]==1){
              toastr.success("Oferta eliminada con éxito");
              licitacion(elid);
            }else{
    
            }
          }
        });
        /*swal(
          '¡Éxito!',
          'Materiales ya en posesión del encargando',
          'success'
        );*/
      } else if (result.dismiss === swal.DismissReason.cancel) {
        swal(
          'Operación cancelada',
          
        );
      }
    });
    
  });

    //registrarle empleado al proyecto
    $(document).on("click","#nuevo_empleado",function(e){
      e.preventDefault();
      $("#modal_registrar_empleado").modal("show");
    });

    $(document).on("click","#guardar_empleado",function(e){
      e.preventDefault();
      var datos=$("#form_guardar_empleado").serialize();
      var valid=$("#form_guardar_empleado").valid();
      modal_cargando();
      if(valid){
        $.ajax({
          url:'../detalleplanillas/store2',
          type:'post',
          dataType:'json',
          data:datos,
          success: function(json){
            if(json[0]==1){
              swal.closeModal();
              empleados(elid);
              toastr.success("Empleado registrado exitosamente");
              $("#modal_registrar_empleado").modal("hide");
              $("#form_guardar_empleado").trigger("reset");
              $(".chosen-select-width").trigger("chosen:updated");
            }else{
              swal.closeModal();
              toastr.error("Ocurrió un error");
            }
          }, error: function(error){
            $.each(error.responseJSON.errors, function( key, value ) {
              toastr.error(value);
            });
            swal.closeModal();
          }
        });
      }
    });

    $(document).on("click","#quitar_empleado",function(e){
      e.preventDefault();
      var proyecto_id=$(this).attr("data-proyecto");
      var id=$(this).attr("data-id");
      modal_cargando();
      $.ajax({
        url:'../proyectos/quitarempleado',
        type:'POST',
        data:{proyecto_id,id},
        success: function(json){
          if(json[0]==1){
            toastr.success("Empleado eliminado con exito");
            //window.location.reload();
            swal.closeModal();
            empleados(elid);
          }else{
            if(json[0]==-2){
              toastr.error(json[2]);
              swal.closeModal();
            }else{
              toastr.error("Ocurrió un error");
              swal.closeModal();
            }
          }
        }
      })
    });

    ///boton nueva jornada empleado
    $(document).on("click","#nueva_jornada", function(e){
      e.preventDefault();
      $("#jornadas_aqui").hide();
      $("#jornada_form").show();
    });

    $(document).on("click","#btn_cancelarjornada", function(e){
      e.preventDefault();
      $("#jornadas_aqui").show();
      $("#jornada_form").hide();
      $("#form_jornada").trigger("reset");
      $(".chosen-select-width").trigger("chosen:updated");
    });

    //cargar los empleados
    $(document).on("click","#elpago",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      cargar_planilla(elid,id);
      $("#tabla_empleados").hide();
      $("#tabla_planilla").show();
    });

    $(document).on("click","#cancelar_planilla",function(e){
      e.preventDefault();
      $("#tabla_empleados").show();
      $("#tabla_planilla").hide();
    });

    //calcular el total segun planilla
    $(document).on("keyup",".losdias", function(e){
      e.preventDefault();
      var dias=0;
      var valor=parseInt($(this).val() || 0);
      
      var salario_dia=parseFloat($(this).attr("data-saldia"));
      var fila=$(this).parent("td").parent("tr");
      var total=valor*salario_dia;
      var renta=total*0.1;
      var totalt=total-renta;
      $(fila).children("td:eq(4)").text("$"+total.toFixed(2));
      $(fila).children("td:eq(5)").text("$"+renta.toFixed(2));
      $(fila).children("td:eq(6)").text("$"+totalt.toFixed(2));
      
    });

    $(document).on("blur",".losdias", function(e){
      e.preventDefault();
      var dias=0;
      var valor=parseInt($(this).val() || 0);
      if(valor<=14){
        var salario_dia=parseFloat($(this).attr("data-saldia"));
      var fila=$(this).parent("td").parent("tr");
      var total=valor*salario_dia;
      var renta=total*0.1;
      var totalt=total-renta;
      $(fila).children("td:eq(4)").text("$"+total.toFixed(2));
      $(fila).children("td:eq(5)").text("$"+renta.toFixed(2));
      $(fila).children("td:eq(6)").text("$"+totalt.toFixed(2));
      }else{
        valor=14;
        $(this).val(valor);
        var salario_dia=parseFloat($(this).attr("data-saldia"));
      var fila=$(this).parent("td").parent("tr");
      var total=valor*salario_dia;
      var renta=total*0.1;
      var totalt=total-renta;
      $(fila).children("td:eq(4)").text("$"+total.toFixed(2));
      $(fila).children("td:eq(5)").text("$"+renta.toFixed(2));
      $(fila).children("td:eq(6)").text("$"+totalt.toFixed(2));
      }
      
      
    });

    //guardar empleado
    $(document).on("click","#btn_guardarjornada", function(e){
      modal_cargando();
        var datos=$("#form_jornada").serialize();
        $.ajax({
          url:'../jornadas',
          type:'POST',
          dataType:'json',
          data:datos,
          success: function(json){
          if(json[0]==1){
            toastr.success("Contrato registrado con exito");
            //window.location.reload();
            $("#btn_cancelarjornada").trigger("click");
            swal.closeModal();
            pagos(elid);
          }else{
            if(json[0]==-2){
              toastr.error(json[2]);
              swal.closeModal();
            }else{
              toastr.error("Ocurrió un error");
              swal.closeModal();
            }
          }
          }, error: function(error){
            $.each(error.responseJSON.errors,function(index,value){
                    toastr.error(value);
                  });
                  swal.closeModal();
          }
        });
    });

    //modal acta de cierre
    $(document).on("click","#finalizar_proyecto", function(e){
      e.preventDefault();
      $("#modal_subir_acta").modal("show");
    });

    $(document).on('submit','#form_subiracta', function(e) {
      // evito que propague el submit
      e.preventDefault();
      //modal_cargando();
      // agrego la data del form a formData
      var formData = new FormData(this);
      formData.append('_token', $('input[name=_token]').val());
      var fi= document.getElementById('file-upload2');
      var tamanio =fi.files[0].size/1024/1024;
      console.log(tamanio +"MB");
      if(tamanio <= 10){
          $.ajax({
            type:'POST',
            url:'../proyectos/subiracta', 
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data[0]==1){
                  toastr.success("Acta subida con éxito");
                  informacion(data[2]);
                  $("#modal_subir_acta").modal("hide");
                  $("#form_subiracta").trigger("reset");
                  swal.closeModal();
                }
            },
            error: function(error){
                swal.closeModal();
              $.each(error.responseJSON.errors, function( key, value ) {
                toastr.error(value);
                swal.closeModal();
              });
            }
        });
      }else{
        toastr.error('El archivo debe pesar menos de 10MB');
      }
});

    //ver planilla
    $(document).on("click","#crear_planilla", function(e){
      var id=elid;
      $.ajax({
        url:'../proyectos/planilla/'+id,
        type:'get',
        dataType:'json',
        success: function(json){
          if(json[0]==1){
            $("#plani_aqui").empty();
            $("#plani_aqui").html(json[2]);
            $("#laplanilla").hide();
            $("#plani_aqui").show();
          }
        }
      })
    });

    $(document).on("click","#cance_plani",function(e){
      e.preventDefault();
      $("#plani_aqui").empty();
      $("#laplanilla").show();
      $("#plani_aqui").hide();
    });
    
    //guardar la planilla
    $(document).on("click","#guardar_plani",function(e){
      var proyecto_id=$(this).attr("data-proyecto");
      var catorcena_id=$(this).attr("data-catorcena");
      var datos=$("#form_planilla").serialize();
      modal_cargando();
      $.ajax({
        url:'../proyectos/guardarplanilla',
        type:'post',
        data:datos+"&proyecto_id="+proyecto_id+'&catorcena_id='+catorcena_id,
        success: function(json){
          if(json[0]==1){
            toastr.success("Planilla generada con exito");
            pagos(elid);
            swal.closeModal();
            $("#cancelar_planilla").trigger("click");
          }else{
            swal.closeModal();
            toastr.error("Ocurrió un error");
          }
        }
      });
    });


    //pagar l planilla
    $(document).on("click","#pagarplanilla",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      $.ajax({
        url:'../planillaproyectos/cambiarestado/'+id,
        type:'GET',
        success: function(json){
          if(json[0]==1){
            toastr.success("Planilla se envió para pago");
            pagos(elid);
          }
        }
      })
    });

    //echar en marca la licitación
    $(document).on("click",".cambiar_licitacion",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      var estado=$(this).attr("data-estado");
      swal({
        title: '¿Está seguro de realizar esta operación?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si!',
        cancelButtonText: '¡No!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url:'../proyectos/cambiarlicitacion',
            type:'post',
            dataType:'json',
            data:{id:id,estado:estado},
            success: function(json){
              if(json[0]==1){
                toastr.success(json[3]);
                informacion(elid);
              }else{
                toastr.error("Ocurrió un error");
              }
            }, error: function(error){

            }
          });
        } else if (result.dismiss === swal.DismissReason.cancel) {
          swal(
            'Operación cancelada',
            
          );
        }
      });
    });
});



function cambiar(){
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info3').innerHTML = pdrs;
  }

  function cambiar2(){
    var pdrs = document.getElementById('file-upload2').files[0].name;
    document.getElementById('info4').innerHTML = pdrs;
  }

  function cambiar3(){
    var pdrs = document.getElementById('file-upload3').files[0].name;
    document.getElementById('info5').innerHTML = pdrs;
  }

  function cambiar4(){
    var pdrs = document.getElementById('file-upload4').files[0].name;
    document.getElementById('info6').innerHTML = pdrs;
  }

function cargar_planilla(elid,id){
  modal_cargando();
  $.ajax({
    url:'../proyectos/generarplanilla/'+elid+'/'+id,
    type:'get',
    success: function(json){
      if(json[0]==1){
        swal.closeModal();
        $("#tabla_planilla").empty();
        $("#tabla_planilla").html(json[2]);
      }
    },
    error: function(error){

    }
  })
}