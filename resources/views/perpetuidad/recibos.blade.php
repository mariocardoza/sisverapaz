@extends('layouts.app')

@section('migasdepan')
<h1>
    Recibos de titulos a perpetuidad
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/ingresos') }}"><i class="fa fa-home"></i> Ingresos</a></li>
        <li class="active">Recibos de titulos a perpetuidad</li>
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
            <div class="btn-group">
              <a href="{{url('ingresos?n=0')}}" class="btn btn-primary">Cobros inmuebles</a>
              <a href="{{url('ingresos?n=1')}}" class="btn btn-primary">Cobros negocios</a>
                <a href="{{ url('partidas') }}" class="btn btn-primary">Partidas <span class="label label-danger">{{\App\Partida::whereEstado(1)->count()}}</span></a>
              <a href="{{url('construcciones/recibos')}}" class="btn btn-primary">Construcciones <span class="label label-danger">{{\App\Construccion::whereEstado(3)->count()}}</span></a>
              <a href="{{url('perpetuidad/recibos')}}" class="btn btn-primary">Titulos a perpetuidad <span class="label label-danger">{{\App\Perpetuidad::whereEstado(1)->count()}}</span></a>
              <button class="btn btn-primary">Otros</button>
            </div>
            <br><br>
            <table class="table table-striped table-bordered table-hover" id="example2">
              <thead>
                <th>N°</th>
                <th>Contribuyente</th>
                <th>Detalle</th>
                <th>Monto</th>
                <th>Fiestas</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acción</th>
              </thead>
              <tbody>
                @foreach ($recibos as $i=> $r)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$r->contribuyente->nombre}}</td>
                        <td>Cobro por derecho de nicho</td>
                        <td>${{number_format($r->costo,2)}}</td>
                        <td>${{number_format($r->costo*($r->fiestas/100),2)}}</td>
                        <td>${{number_format($r->costo+($r->costo*($r->fiestas/100)),2)}}</td>
                        <td>
                            @if($r->estado==1)
                            <label for="" class="label-primary col-sm-12">Recibo emitido</label>
                            @elseif($r->estado==2)
                            <label for="" class="label-danger col-sm-12">Anulada</label>
                            @else
                            <label for="" class="label-success col-sm-12">Pagado</label>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-success vista_previa" href="{{url ('reportestesoreria/recibop/'.$r->id)}}" target="_blank"><i class="fa fa-print"></i></a>
                            <button class="btn btn-primary cobrar" data-id="{{ $r->id }}"><i class="fa fa-money"></i></button>
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
     /* cobrar la partida */
     $(document).on("click",".cobrar",function(e){
            e.preventDefault();
            let id=$(this).attr("data-id");
            swal({
                title: '',
                text: "¿Desea registrar este pago?",
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
                        url:'/perpetuidad/cobro',
                        type:'post',
                        dataType:'json',
                        data:{id},
                        success: function(json){
                            if(json[0]==1){
                                toastr.success("Pago recibido");
                                location.reload();
                                }else{
                                toastr.error("Ocurrió un error");
                                swal.closeModal();
                                }
                            }, error: function(error){
                                toastr.error("Ocurrió un error");
                                swal.closeModal();
                            }
                    });
                    
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        swal(
                            'Revise el recibo por favor',
                            '',
                            'info'
                        );
                    }
            });
        });

  });
</script>
@endsection