@extends('layouts.app')

@section('migasdepan')
<h1>
    Puestos a perpetuidad
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li><a href="{{ url('/perpetuidad') }}"><i class="glyphicon glyphicon-home"></i> Titulos a perpetuidad</a></li>
    <li class="active">Nuevo</li>
  </ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header">
        <div class="box-title">
            <h4>Nuevo</h4>
        </div>
    </div>
    <div class="box-body">
        <div class="panel panel-primary elpanel-mapa">
            <div class="panel-heading">
                Registro de título a perpetuidad
            </div>
            <div class="panel-body">
                <div class="row">
                    
                </div>
                <div class="row" id="divmapa" style="display: block;">
                    <br>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading"></div>
                            <div class="panel-body">
                                <form class="form" id="form_perpetuidad">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="" class="control-label">Cementerio</label>
                                                <select name="cementerio_id" id="elcem" class="chosen-select wisth">
                                                    <option value="">Seleccione el cementerio</option>
                                                    @foreach ($cementerios as $c)
                                                        <option value="{{$c->id}}">{{$c->nombre}}</option>  
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="" class="control-label">Propietario</label>
                                            <select name="contribuyente_id" class="chosen-select-width">
                                                @foreach ($contribuyentes as $c)
                                                    <option value="{{$c->id}}">{{$c->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="" class="control-label">Tipo de nicho</label>
                                            <select name="tipo" class="chosen-select-width">
                                                <option value="Normal con sótano a contracava">Normal con sótano a contracava</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <span class="text-center">Medidas</span>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Centímetros de ancho</label>
                                            <input type="number" step="any" class="form-control" name="ancho">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Metros de largo</label>
                                            <input type="number" step="any" class="form-control" name="largo">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Linda al norte</label>
                                            <input type="text" class="form-control" name="norte">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Linda al sur</label>
                                            <input type="text" class="form-control" name="sur">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Linda al oriente</label>
                                            <input type="text" class="form-control" name="oriente">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Linda al poniente</label>
                                            <input type="text" class="form-control" name="poniente">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Valor del título</label>
                                            <input type="number" step="any" class="form-control" name="costo">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="" class="control-label">Fecha</label>
                                            <input type="text"  autocomplete="off" value="{{date("d-m-Y")}}" class="form-control fechanomayor">
                                        </div>
                                        <div class="hide col-sm-12">
                                            <input type="text" name="lat" id="lat">
                                            <input type="text" name="lng" id="lng">
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <button class="btn btn-primary" type="submit">Registrar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="mapita" style="height: 450px;"></div>
                    </div>
                    <br><br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var cementerioCoords=[];
    $(document).ready(function(e){

        //guardar el titulo
        $(document).on("submit","#form_perpetuidad",function(e){
            e.preventDefault();
            var datos=$("#form_perpetuidad").serialize();
            $.ajax({
                url:'../perpetuidad',
                type:'post',
                dataType:'json',
                data:datos,
                success: function(json){
                    if(json[0]==1){
                        toastr.success("Título guardado con éxito");
                        location.href="../perpetuidad";
                    }
                }
            });
        });

        //obtener ubicacion del cementerio
        $(document).on("change","#elcem",function(e){
            e.preventDefault();
            var id=$(this).val();
            $.ajax({
                url:'../cementerios',
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
                        $("#divmapa").show();

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
          mapTypeId: google.maps.MapTypeId.SATELLITE 
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

      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        $("#lat").val(this.getPosition().lat());
        $("#lng").val(this.getPosition().lng());
      });

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