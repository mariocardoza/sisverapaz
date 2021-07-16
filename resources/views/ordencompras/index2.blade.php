@extends('layouts.app')

@section('migasdepan')
      <h1>
       Pago de ordenes de compras
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/ordencompras') }}"><i class="fa fa-dashboard"></i> Ordenes de Compra</a></li>
        <li class="active">Listado de ordenes</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
  <div class="box">
    <p></p>
    <div class="box-header">
      <p></p>
      <div class="btn-group pull-left">
        <a href="{{url('pagos')}}" class="btn btn-primary ">Pagos</a>
        <a href="javascript:void(0)" class="btn btn-primary active">Ordenes de Compra</a>
      </div>
      <div class="btn-group pull-right">
        <a href="{{ url('pagos/ordencompras?estado=1') }}" class="btn btn-danger">Pendientes</a>
        <a href="{{ url('pagos/ordencompras?estado=3') }}" class="btn btn-primary">Pagadas</a>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table class="table table-striped table-bordered table-hover" id="example2">
        <thead>
          <th>N°</th>
          <th>Correlativo orden</th>
          <th>Monto a pagar</th>
          <th>Proveedor</th>
          <th>Proyecto o proceso</th>
          <th>Financiamiento</th>
          <th>Estado</th>
          <th>Accion</th>
          <?php $contador=0 ?>
        </thead>
        <tbody>
          @foreach($ordenes as $orden)
            <tr>
              @php
                $contador++;
              @endphp
              <td>{{$contador}}</td>
              @if($orden->tipo==1)
              <td>{{$orden->numero_orden}}</td>
              <td class="text-right">${{number_format(App\Detallecotizacion::total_cotizacion($orden->cotizacion->id),2)}}</td>
              <td>{{$orden->cotizacion->proveedor->nombre}}</td>
                @if($orden->cotizacion->solicitudcotizacion->tipo==1)
                <td>{{$orden->cotizacion->solicitudcotizacion->proyecto->nombre}}</td>
                <td>
                  @foreach ($orden->cotizacion->solicitudcotizacion->proyecto->fondo as $f)
                      {{$f->cuenta->nombre}},
                  @endforeach
                </td>
                @elseif($orden->cotizacion->solicitudcotizacion->tipo==2)
                  <td>{{$orden->cotizacion->solicitudcotizacion->requisicion->actividad}}</td>
                  <td>{{$orden->cotizacion->solicitudcotizacion->requisicion->cuenta->nombre}}</td>
                @else 
                <td>
                @foreach ($orden->cotizacion->solicitudcotizacion->solirequi->requisiciones as $index => $item)
                <b>Actividad N°: {{$index+1}}</b> {{$item->actividad}},
                @endforeach
              </td>
              <td>{{$orden->cotizacion->solicitudcotizacion->solirequi->cuenta->nombre}}</td>
                @endif
                @if($orden->estado==3)
                <td><label for="" class="label-primary">Desembolso pendiente</label></td>
                <td>
                  <div class="btn-group">
                    <a href="{{ url('reportesuaci/ordencompra/'.$orden->id) }}" class="btn btn-success vista_previa" target="_blank" title="Imprimir orden de compra"><i class="fa fa-file-pdf-o"></i></a>
                    <button class="btn btn-primary pagar_orden" title="Realizar pago"  type="button" data-id="{{$orden->id}}"><i class="fa fa-money"></i></button>
                  </div>
                </td>
              @elseif($orden->estado==4) 
              <td><label for="" class="label-success">Pago realizado</label></td>
              <td>
                <div class="btn-group">
                  <a href="{{ url('reportesuaci/ordencompra/'.$orden->id) }}" class="btn btn-success vista_previa" target="_blank" title="Imprimir orden de compra"><i class="fa fa-file-pdf-o"></i></a>
                </div>
              </td>
              @endif
      {{-- AQUI TERMINAN LAS FUNCIONES DE BOTONES PARA ORDENES POR PROCESOS DE COTIZACION --}}

              @else 
      {{-- AQUI VA LAS FUNCIONES DE BOTONES PARA ORDENES POR COMPRA DIRECTAS --}}
              <td>{{$orden->numero_orden}}</td>
              <td class="text-right">${{number_format($orden->compradirecta->monto,2)}}</td>
              <td>{{$orden->compradirecta->proveedor->nombre}}</td>
              <td>{{$orden->compradirecta->nombre}}</td>
              <td>{{$orden->compradirecta->cuenta->nombre}}</td>
              @if($orden->estado==3)
                  <td><label for="" class="label-primary">Desembolso pendiente</label></td>
                  <td>
                    <div class="btn-group">
                      <a href="{{ url('reportesuaci/ordencompra2/'.$orden->id) }}" class="btn btn-success vista_previa" target="_blank" title="Imprimir orden de compra"><i class="fa fa-file-pdf-o"></i></a>
                      <button class="btn btn-primary pagar_directa" title="Realizar pago" type="button" data-id="{{$orden->id}}"><i class="fa fa-money"></i></button>
                    </div>
                  </td>
                @elseif($orden->estado==4)
                  <td><label for="" class="label-success">Pago realizado</label></td>
                  <td>
                    <a class="btn btn-primary vista_previa" href="{{url('reportesuaci/ordencompra2/'.$orden->id)}}"><span class="glyphicon glyphicon-eye-open"></span></a>
                  </td>
                @endif
              @endif
             
            
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function(){
    //anular la orden
    $(document).on("click",".pagar_orden",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
          title: 'Desembolso',
          text: "¿Desea realizar el desembolso al proveedor?",
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
            modal_cargando();
            $.ajax({
            url:'../ordencompras/pagar/'+id,
            type:'get',
            dataType:'json',
            success:function(json){

            },
            error: function(error){

            }
          });
          } else if (result.dismiss === swal.DismissReason.cancel) {
            swal(
              'Nueva revisión',
              'Se pide verificar bien los materiales',
              'info'
            );
          }
        });

      
    });
  });
</script>
@endsection
