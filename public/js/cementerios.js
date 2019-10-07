window.onload = function () {
    var pointers;
    var selectedShape;

    function getToolsBarMap(polygon) {
        selectedShape = polygon.overlay;
        drawingManager.setDrawingMode(null);
        drawingManager.setOptions({
            drawingControl: false
        });

        google.maps.event.addListener(selectedShape, 'dblclick', function(shape) {
            drawingManager.setOptions({
                drawingControl: true
            });
            selectedShape.setMap(null);
            pointers = [];
        });
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
            if(pointers.length > 0) {
                var arrayPointer = pointers.map(function(item) {
                    return [
                        item.lat(), item.lng()
                    ]
                });
                console.log(arrayPointer);                
            } else {
                toastr.error("Debes de dibujar el area para el cementerio");
            }
        }
    });
}