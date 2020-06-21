window.onload = function () {
    var pointers;
    var selectedShape;

    function deletePathMap () {
        swal({
            title: 'Esta seguro que desea borrar el área seleccionada?',
            text: "Una vez borrada no podrá recuperar la información",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy de acuerdo!'
          }).then((result) => {
            if (result.value) {
                Swal.fire('Exito!', 'El área fue borrada con éxito ', 'success' )
                drawingManager.setOptions({
                    drawingControl: true
                });
                selectedShape.setMap(null);
                pointers = [];
            }
        })

        
    }

    function getToolsBarMap(polygon) {
        selectedShape = polygon.overlay;
        drawingManager.setDrawingMode(null);
        drawingManager.setOptions({
            drawingControl: false
        });

        google.maps.event.addListener(selectedShape, 'dblclick', deletePathMap);
    }

    function servidorAjax(pointers, formulario) {
        $.ajax({
            url:'../cementerios',
            type:'post',
            dataType:'json',
            data:{pointers,form:formulario}
        }).
        done(function(respuesta) {
            swal({
                title: 'Éxito!',
                text: 'Hemos guardo con éxito los datos del cementerio',
                type: 'success'
            }).then(function() {
                window.href="../cementerios/"+respuesta.id;
            });
        }).fail(function(err){
            toastr.error(err);
        })
    }

    google.maps.event.addListener(drawingManager, "overlaycomplete", function(polygon) { 
        getToolsBarMap(polygon);     
        google.maps.event.addListener(polygon.overlay.getPath(), "insert_at", function() {
            pointers = (polygon.overlay.getPath().getArray());
        });
        google.maps.event.addListener(polygon.overlay.getPath(), "set_at", function() {
            pointers = (polygon.overlay.getPath().getArray());
        });
    });

    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
        pointers = (polygon.getPath().getArray());
    });
    
    google.maps.event.addDomListener(document.getElementById('formulario'), 'submit', function(e){
        e.preventDefault();
        var bandera = false
        var data = $(this).serializeArray();

        $.each(data, function(key, item){
            if(!item.value) {
                bandera = true;
                toastr.error("El campo " + item.name + "  es requerido");
            }
        })

        if(!bandera) {
            if(pointers && pointers.length > 0) {
                var arrayPointer = pointers.map(function(item) {
                    return [
                        item.lat(), item.lng()
                    ]
                });
                servidorAjax(arrayPointer, {
                    nombre: data[0]["value"],
                    maximo: data[1]["value"],
                })
            } else {
                toastr.error("Debes de dibujar el área para el cementerio");
            }
        }
    });
}