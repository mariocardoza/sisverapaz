$(document).ready(function (e) {
    $(document).on("click", "#registrar_vacacion", function (e) {
        var valid = $("#form_vacacion").valid();
        if (valid) {
            modal_cargando();
            var datos = $("#form_vacacion").serialize();
            $.ajax({
                url: 'vacaciones/fecha',
                type: 'POST',
                dataType: 'json',
                data: datos,
                success: function (json) {
                    if (json[0] == 1) {
                        toastr.success("Fecha registrada con éxito");
                        window.location.reload();
                    } else {
                        toastr.error("Ocurrió un error");
                        swal.closeModal();
                    }
                }, error: function (error) {
                    $.each(error.responseJSON.errors, function (index, value) {
                        toastr.error(value);
                    });
                    swal.closeModal();
                }
            })
        }
    });
    $(document).on("click", "#btn_vacacion", function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var pago = $(this).attr('data-pago');
        $('#id_vacacion').val(id);
        $('#pago').val(pago);
        $('#modal_fecha').modal('show');
    });
});
