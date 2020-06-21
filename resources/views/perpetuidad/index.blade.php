@extends('layouts.app')

@section('migasdepan')
<h1>
    Puestos a perpetuidad
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li class="active">Nuevo</li>
  </ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header">
        <div class="box-title">
            <h3>Puesto a perpetuidad</h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="control-label">Cementerio</label>
                    <select name="" id="elcem" class="chosen-select wisth">
                        <option value="">Seleccione el cementerio</option>
                        @foreach ($cementerios as $c)
                            <option value="{{$c->id}}">{{$c->nombre}}</option>  
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                <div id="mapita" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var cementerioCoords=[];
    $(document).ready(function(e){

        //obtener ubicacion del cementerio
        $(document).on("change","#elcem",function(e){
            e.preventDefault();
            var id=$(this).val();
            $.ajax({
                url:'cementerios',
                type:'get',
                dataType:'json',
                data:{id:id},
                success: function(json){
                    if(json[0]==1){
                        if(json[2]!=null){
                            cementerioCoords=[];
                            for(var i=0;i<json[2].length;i++){
                                cementerioCoords.push({
                                lat : parseFloat(json[2][i].latitud),
                                lng : parseFloat(json[2][i].longitud),
                                });
                            }
                            initMap(parseFloat(json[2][1].latitud),parseFloat(json[2][1].longitud));

                        }
                    }
                }
            });
        });
    });
    initMap = function (lat,lng) 
{

    
    var map = new google.maps.Map(document.getElementById('mapita'), {
          zoom: 19,
          center: {lat: lat, lng: lng},
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Define the LatLng coordinates for the polygon's path.


        // Construct the polygon.
        var cementerio = new google.maps.Polygon({
          paths: cementerioCoords,
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillOpacity: 0.35,
          clickable: true
        });
        cementerio.setMap(map);

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP,
            position: new google.maps.LatLng(lat,lng),
      });

      marker.addListener('click', toggleBounce);

}



function setMapa (coords)
{   
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('mapita'),
      {
        zoom: 15,
        center:new google.maps.LatLng(13.643449058476703,-88.87197894152527),

      });


      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: new google.maps.LatLng(coords.lat,coords.lng),
      });
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);
      
      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
      });
}

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}
</script>
@endsection