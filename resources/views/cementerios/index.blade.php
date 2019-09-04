<html>
    <head>
        {!! $map['js'] !!}
    </head>
<body>
    <div class="container">
        <div class="content">
            {!! $map['html'] !!}
        </div>
    </div>
    
    <script type='text/javascript'>
        window.onload = function() {
            google.maps.event.addListener(drawingManager, "overlaycomplete", getPolygonCoords);
            function getPolygonCoords(polygon) {
                drawingManager.drawingControl = false;
                google.maps.event.addListener(polygon.overlay.getPath(), "insert_at", function() {
                    // console.log(polygon.overlay.getPath().getArray())
                    console.log(drawingManager)
                });                
                google.maps.event.addListener(polygon.overlay.getPath(), "set_at", function() {
                    polygon.overlay.getPath().getArray().forEach(element => {
                        console.log("Lat> " + element.lat() + " " + element.lng());
                    });
                });
            }
        }
    </script>
</body>
</html>