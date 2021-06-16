@extends('layouts.app')

@section('migasdepan')
<h1>
 
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
    <li><a href="{{ url('/perpetuidad') }}"><i class="glyphicon glyphicon-home"></i> Titulos a Perpetuidad</a></li>
    <li class="active">Ver</li>
  </ol>
@endsection
@section('content')
<div class="box">
    <div class="box-header">
        <div class="box-title">
            <h3>Título a perpetuidad</h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <table class="table">
                    <tbody>
                       <tr>
                           <th>Propietario</th>
                           <td>{{$perpetuidad->contribuyente->nombre}}</td>
                       </tr>
                       <tr>
                        <th>Cementerio</th>
                        <td>{{$perpetuidad->cementerio->nombre}}</td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td>{{$perpetuidad->tipo}}</td>
                    </tr>
                    <tr>
                        <th>Ancho en centímetros</th>
                        <td>{{$perpetuidad->ancho}}</td>
                    </tr>
                    <tr>
                        <th>Largo en metros</th>
                        <td>{{$perpetuidad->largo}}</td>
                    </tr>
                    <tr>
                        <th>Costo</th>
                        <td>${{number_format($perpetuidad->costo,2)}}</td>
                    </tr>
                    <tr>
                      <th>L/Norte</th>
                      <td>{{$perpetuidad->norte}}</td>
                    </tr>
                    <tr>
                      <th>L/Sur</th>
                      <td>{{$perpetuidad->sur}}</td>
                    </tr>
                    <tr>
                      <th>L/Oriente</th>
                      <td>{{$perpetuidad->oriente}}</td>
                    </tr>
                    <tr>
                      <th>L/Poniente</th>
                      <td>{{$perpetuidad->poniente}}</td>
                    </tr>
                    </tbody>
                </table>
                <div style="display: block; margin: 0 auto;" class="btn-group">
                  <button id="edit_perpetuidad" data-id="{{$perpetuidad->id}}" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                  <a href="{{url('reportestesoreria/recibop/'.$perpetuidad->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i></a>
                </div>
                <br>
                <h3>Beneficiarios <button type="button" class="btn btn-success pull-right agregar_beneficiario"><i class="fa fa-plus"></i></button></h3>
                <table class="table">
                  <thead>
                    <tr>
                      <th>N°</th>
                      <th>Nombre</th>
                      <th>Fecha sepultado</th>
                      <th>fecha exhumacion</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($perpetuidad->beneficiarios as $i => $beneficiario)
                        <tr>
                          <td>{{$i+1}}</td>
                          <td>{{$beneficiario->beneficiario}}</td>
                          <td>{{$beneficiario->fecha_entierro->format('d/m/Y')}}</td>
                          <td>{{$beneficiario->fecha_exhumacion == '' ? 'S/N':$beneficiario->fecha_exhumacion->format("d/m/Y")}}</td>
                          <td><button class="btn btn-warning"><i class="fa fa-edit"></i></button></td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <div id="mapita" style="height: 450px;"></div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_beneficiario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Registrar Beneficiario</h4>
			</div>
			<div class="modal-body">
				<form id="form_beneficiario">
					<div class="form-group">
						<label for="">
							Nombre
						</label>
						<input type="text" name="beneficiario" autocomplete="off" class="form-control">
						<input type="hidden" name="perpetuidad_id" value="{{$perpetuidad->id}}" autocomplete="off" class="form-control">
					</div>
				<div class="form-group">
          <label for="">Fecha entierro</label>
          <input type="text" class="form-control fechanomayor" autocomplete="off" name="fecha_entierro">
        </div>
			</div>
			<div class="modal-footer">
				<center>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success">Guardar</button>
				</center>
      </div>
    </form>
		</div>
	</div>
</div>
<div id="modal_aqui"></div>
@endsection
@section('scripts')
<script>
    var cementerioCoords=[];
    var lat=parseFloat('<?php echo $perpetuidad->lat ?>');
    var lng=parseFloat('<?php echo $perpetuidad->lng ?>');
    $(document).ready(function(e){
        initMap(lat,lng);

        //modal registrar un beneficiario al puesto
        $(document).on("click",".agregar_beneficiario",function(e){
          e.preventDefault();
          $("#modal_beneficiario").modal("show");
        });

        //editar un puesto a perpetuidad
        $(document).on("click","#edit_perpetuidad",function(e){
          e.preventDefault();
          let id=$(this).attr("data-id");
          $.ajax({
            url:'../perpetuidad/'+id+'/edit',
            type:'get',
            dataType:'json',
            success:function(json){
              if(json[0]==1){
                $("#modal_aqui").empty();
                $("#modal_aqui").html(json[2]);
                $('.fechanomayor').datepicker({
                  selectOtherMonths: true,
                  changeMonth: true,
                  changeYear: true,
                  dateFormat: 'dd-mm-yy',
                  maxDate: "+1m",
                  format: 'dd-mm-yyyy'
                });
                $(".chosen-select-width").chosen({width:'100%'});
                $("#modal_edit_perpetuidad").modal("show");
              }
            }
          });
        });

        //registrar el beneficiario
        $(document).on("submit","#form_beneficiario",function(e){
          e.preventDefault();
          let datos = $("#form_beneficiario").serialize();
          modal_cargando();
          $.ajax({
            url:'../perpetuidad/beneficiario',
            type:'post',
            dataType:'json',
            data:datos,
            success:function(json){
              if(json[0]==1){
                toastr.success("Beneficiario registrado con exito");
                location.reload();
              }
              if(json[0]==2){
                swal.closeModal();
                toastr.info(json[1]);
              }
            },
            error: function(error){

            }
          })
        });

        //edityar perpetuidad
        $(document).on("click","#btn_editp",function(e){
          e.preventDefault();
          let datos = $("#form_edit_perpetuidad").serialize();
          let id =$(this).attr("data-id");
          modal_cargando();
          $.ajax({
            url:'../perpetuidad/'+id,
            type:'put',
            dataType:'json',
            data:datos,
            success:function(json){
              if(json[0]==1){
                toastr.success("Beneficiario editado con exito");
                location.reload();
              }
              else{
                swal.closeModal();
                toastr.error('Ocurrio un error, contacte al administrador');
              }
            },
            error: function(error){
              swal.closeModal();
            }
          })
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
function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}
</script>
@endsection