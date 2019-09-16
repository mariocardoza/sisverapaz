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
});

function cambiar(){
    var pdrs = document.getElementById('file-upload').files[0].name;
    document.getElementById('info3').innerHTML = pdrs;
  }