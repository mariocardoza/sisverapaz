@extends('layouts.app')

@section('migasdepan')
<h1>
        Ingresos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/ingresos') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Ingresos totales</li>
      </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"></h3>
              
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <div class="btn-group pull-right">
              <a href="{{url('ingresos?n=0')}}" class="btn btn-primary">Cobros Inmuebles</a>
              <a href="{{url('ingresos?n=1')}}" class="btn btn-primary">Cobros Negocios</a>
              <a href="{{ url('partidas') }}" class="btn btn-primary">Partidas</a>
              <a href="{{url('construcciones/recibos')}}" class="btn btn-primary">Construcciones <span class="label label-danger">{{\App\Construccion::whereEstado(3)->count()}}</span></a>
              <a href="{{url('perpetuidad/recibos')}}" class="btn btn-primary">Titulos a Perpetuidad <span class="label label-danger">{{\App\Perpetuidad::whereEstado(1)->count()}}</span></a>
              <button class="btn btn-primary">Otros</button>
            </div>
            <br><br>
            <br><br>
            <table class="table table-striped table-bordered table-hover" id="example2">
              <thead>
                <th>N°</th>
                <th>N° cuenta</th>
                <th>Contribuyente</th>
                <th>Detalle</th>
                <th>Periodo</th>
                <th>Subtotal</th>
                <th>Mora</th>
                <th>Fiestas</th>
                <th>Total</th>
                <th>Fecha emisión</th>
                <th>Acción</th>
              </thead>
              <tbody>
                @foreach($facturas as $index => $factura)
                <tr>
                  <td>{{$index+1}}</td>
                  @if($n==0)
                    <td>{{$factura->inmueble->numero_cuenta}}</td>
                    <td>{{$factura->inmueble->contribuyente->nombre}}</td>
                    <td>Cobro por inmueble con N° catastral: {{$factura->inmueble->numero_catastral}}</td>
                  @else
                    <td>{{$factura->negocio->numero_cuenta}}</td>
                    <td>{{$factura->negocio->contribuyente->nombre}}</td>
                    <td>Cobro por negocio: {{$factura->negocio->nombre}}</td>
                  @endif
                  <td>{{$factura->mesYear}}</td>
                  <td>${{$factura->subTotal}}</td>
                  <td>{{$factura->mora==0 ? 'N/A' : '$'.$factura->mora}}</td>
                  <td>${{number_format($factura->pagoTotal*($factura->porcentajeFiestas/100),2)}}</td>
                  <td>${{number_format($factura->pagoTotal+($factura->pagoTotal*($factura->porcentajeFiestas/100)),2)}}</td>
                  <td>{{$factura->created_at->format("d/m/Y")}}</td>
                  <td>
                    @if($n==0)
                      <button data-id="{{ $factura->id }}" id="cobrar_inmueble" class="btn btn-success"><i class="fa fa-money"></i></button>
                    @else
                      <button data-id="{{ $factura->id }}" id="cobrar_negocio" class="btn btn-primary"><i class="fa fa-money"></i></button>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
              
            <div class="pull-right">

            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
</div>
</div>
@endsection
@section('scripts')
<script>
$(function(){
  //cobro a negocios
  $(document).on("click","#cobrar_negocio",function(e){
    e.preventDefault();
    let id = $(this).attr("data-id");
    swal({
			title: '¿Está seguro?',
			text: "¿Desea confirmar el pago?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: '¡Si!',
			cancelButtonText: '¡No!',
			confirmButtonClass: 'btn btn-success',
			cancelButtonClass: 'btn btn-danger',
			buttonsStyling: false,
			reverseButtons: true
		}).then((result) => {
			if (result.value) {
        $.ajax({
          url:'/ingresos/cobro',
          type:'POST',
          dataType:'json',
          data:{id:id,tipo:2},
          success: function(json){
            if(json[0]==1){
              swal(
                '¡Realizado!',
                'Cobro realizado con éxito.',
                'success'
              );
              location.reload();
            }else{
              swal(
                '¡Error!',
                'Contacte al administrador.',
                'error'
              );
            }
          },error:function(error){
            swal(
                '¡Error!',
                'Contacte al administrador.',
                'error'
              );
          }
        })

			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal(
					'Cancelado',
					'Revise el monto de la factura',
					'info'
				)
			}
		})
  });

  //cobro a negocios
  $(document).on("click","#cobrar_inmueble",function(e){
    e.preventDefault();
    let id = $(this).attr("data-id");
    swal({
			title: '¿Está seguro?',
			text: "¿Desea confirmar el pago?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: '¡Si!',
			cancelButtonText: '¡No!',
			confirmButtonClass: 'btn btn-success',
			cancelButtonClass: 'btn btn-danger',
			buttonsStyling: false,
			reverseButtons: true
		}).then((result) => {
			if (result.value) {
        $.ajax({
          url:'/ingresos/cobro',
          type:'POST',
          dataType:'json',
          data:{id:id,tipo:1},
          success: function(json){
            if(json[0]==1){
              swal(
                '¡Realizado!',
                'Cobro realizado con éxito.',
                'success'
              );
              location.reload();
            }else{
              swal(
                '¡Error!',
                'Contacte al administrador.',
                'error'
              );
            }
          },error:function(error){
            swal(
                '¡Error!',
                'Contacte al administrador.',
                'error'
              );
          }
        })

			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal(
					'Cancelado',
					'Revise el monto de la factura',
					'info'
				)
			}
		})
  });
});
</script>
@endsection