$(document).ready(function(e){
    $(document).on("click","#subir_contrato", function(e){
        e.preventDefault();
        $("#modal_subir_contrato").modal("show");
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

    ///boton nuevo empleado
    $(document).on("click","#nuevo_emp", function(e){
      e.preventDefault();
      $("#empleados_aqui").hide();
      $("#emple_form").show();
    });

    $(document).on("click","#btn_cancelarcontrato", function(e){
      e.preventDefault();
      $("#empleados_aqui").show();
      $("#emple_form").hide();
      $("#form_planilla").trigger("reset");
      $(".chosen-select-width").trigger("chosen:updated");
    });

    //guardar empleado
    $(document).on("click","#btn_guardarcontrato", function(e){
      modal_cargando();
        var datos=$("#form_planilla").serialize();
        $.ajax({
          url:'../detalleplanillas',
          type:'POST',
          dataType:'json',
          data:datos,
          success: function(json){
          if(json[0]==1){
            toastr.success("Contrato registrado con exito");
            //window.location.reload();
            $("#btn_cancelarcontrato").trigger("click");
            swal.closeModal();
            empleados(elid);
          }else{
            toastr.error("Ocurrió un error");
            swal.closeModal();
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
      var datos=$("#form_planilla2").serialize();
      console.log(datos);
      $.ajax({
        url:'../prueba',
        type:'post',
        data:datos,
        success: function(json){

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