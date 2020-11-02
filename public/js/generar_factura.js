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
                    $('#inmuebles_espacio').append('<button class="btn btn-info btn-lg" id="props' + propiedad.id + '" onclick="mostarFacturaPedientes(' + propiedad.id + ')">' + propiedad.direccion_inmueble + '</button>')
                })
            } else {
                $('#inmuebles_espacio').empty()
                $('#inmuebles_espacio').append('El contribuyente no tiene ninguna propiedad')
            }
        }
    });
});
function mostarFacturaPedientes(id_inmueble) {
    console.log($(this))
    $("#modal_mis_inmuebles").modal("hide");
    $.ajax({
        type: 'get',
        url: 'inmuebles/buscarfacturas',
        data: {
            id: id_inmueble,
        },
        success: function (r) {
            $("#modal_mis_facturas").modal("show");
            $("#modal_mis_facturas").find('h4').text("Facturas pendientes de: " + $('#props' + id_inmueble).text())
            if (r != 0) {
                $('#facturas_espacio').empty()
                $(r).each(function (key, factura) {
                    $('#facturas_espacio').append('<div class="togglebutton"><label><input type="checkbox" onclick="revisarCheckBox();" cbid="' + factura.id + '"><span class="toggle"></span> ' + factura.mesYear + '</label></div>')
                    // $('#facturas_espacio').append('<button class="btn btn-info btn-lg" onclick="mostarFacturaPedientes(' + .id + ')">' + propiedad.direccion_inmueble + '</button>')
                })
            } else {
                $('#facturas_espacio').empty()
                $('#facturas_espacio').append('El esta propiedad no tiene ninguna factura pendiente de pago')
            }
            revisarCheckBox()
        }
    });

}
function revisarCheckBox() {
    cbs = $('#facturas_espacio').find('input')
    var cont_t = 0; //Variable que lleva la cuenta de los checkbox pulsados   
    for (var x = 0; x < cbs.length; x++) {
        if (cbs[x].checked) {
            cont_t = cont_t + 1;
        }
    }
    if (cont_t > 0) {
        $('#generar_facturas').prop('disabled', false);
        if (cont_t == cbs.length) {
            $('#todos_c').prop('checked', true)
        } else {
            $('#todos_c').prop('checked', false)
        }
    } else {
        $('#generar_facturas').prop('disabled', true);
    }
}
function todos() {
    cbs = $('#facturas_espacio').find('input')
    if ($('#todos_c').prop('checked')) {
        for (var x = 0; x < cbs.length; x++) {
            if (!cbs[x].checked) {
                cbs[x].checked = true;
            }
        }
    } else {
        for (var x = 0; x < cbs.length; x++) {
            if (cbs[x].checked) {
                cbs[x].checked = false;
            }
        }
    }
    revisarCheckBox()
}
function verFacturas() {
    cbs = $('#facturas_espacio').find('input')
    $('#verFacturas').find('.auxInput').remove();
    cbs.each(function () {
        if ($(this).prop('checked')) {
            console.log($(this).attr('cbid'))
            $('#verFacturas').append('<input type="hidden" name="cbid[]" class="auxInput" value="' + $(this).attr('cbid') + '"/>')
        }
    })
    $('#verFacturas').submit()
    // for (var x = 0; x < cbs.length; x++) {
    //     if (cbs[x].checked) {
    //         console.log(cbs[x].getProperty('cbid'))
    //     }
    // }
}