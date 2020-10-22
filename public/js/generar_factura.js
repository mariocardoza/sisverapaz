$(document).on("click", ".ver_mis_inmuebles", function (e) {
    e.preventDefault();
    var id = $(this).attr("data-id");
    fila = $(this)
    $.ajax({
        type: 'get',
        url: 'inmuebles/buscarinmuebles',
        data: {
            id: id,
        },
        success: function (r) {
            $("#modal_mis_inmuebles").modal("show");
            $("#modal_mis_inmuebles").find('h4').text("Inmueble/s del contribuyente: " + fila.parents('tr').find('td:eq(1)').text())
            if (r != 0) {
                $('#inmuebles_espacio').empty()
                $(r).each(function (key, propiedad) {
                    $('#inmuebles_espacio').append('<button class="btn btn-info btn-lg" onclick="mostarFacturaPedientes(' + propiedad.id + ')">' + propiedad.direccion_inmueble + '</button>')
                })
            } else {
                $('#inmuebles_espacio').empty()
                $('#inmuebles_espacio').append('El contribuyente no tiene ninguna propiedad')
            }
        }
    });
});
function mostarFacturaPedientes(id_inmueble) {

}