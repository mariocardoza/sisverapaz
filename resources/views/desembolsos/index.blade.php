@extends('layouts.app')

@section('migasdepan')
<h1>
        Desembolsos
        <small>Movimientos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Movimientos</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Cuenta</th>
                  <th>Detalle</th>
                  <th>Monto a cancelar</th>
                  <th>Impuesto/renta 10%</th>
                  <th>Desembolso total</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </thead>
                <tbody>
                  @foreach($desembolsos as $index => $desembolso)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    @if($desembolso->cuentaproy_id)
                    <td>Proyecto: {{ $desembolso->cuentaproy->proyecto->nombre }}</td>
                    @else
                    <td>{{ $desembolso->cuenta->nombre }}</td>
                    @endif 
                    
                    <td>{{ $desembolso->detalle }}</td>
                    <td class="text-right">${{ number_format($desembolso->monto,2) }}</td>
                    <td class="text-right">${{ number_format($desembolso->renta,2) }}</td>
                    <td class="text-right">${{ number_format($desembolso->renta+$desembolso->monto,2) }}</td>
                    <td class="">{!! \App\Desembolso::estado($desembolso->id) !!}</td>
                    <td>
                        @if($desembolso->estado == 1) 
                            <a href="javascript:void(0)" id="realizar_pago" data-id="{{$desembolso->id}}" title="Ejecutar desembolso" class="btn btn-info"><span class="fa fa-money"></span></a>
                            
                        @else
                            <button class="btn btn-success" type="button" ><span class="fa fa-print"></span></button>
                            
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
  $(document).ready(function(e){
    
    //efectuar el desembolso
    $(document).on("click","#realizar_pago",function(e){
      e.preventDefault();
      var id=$(this).attr("data-id");
      swal({
          title: '¿Está seguro?',
          text: "¿Desea realizarle el desembolso al cliente?",
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
              url:'desembolsos',
              type:'post',
              data:{id},
              success: function(json){
                if(json[0]==1){
                  toastr.success("Desembolso realizado exitosamente");
                  location.reload();
                }else if(json[0]==2){
                  toastr.info(json[2]);
                }else{
                  toastr.error("Ocurrió un error");
                }
              }
            });
            
          } else if (result.dismiss === swal.DismissReason.cancel) {
            swal(
              'Cancelado',
              'Revise la información',
              'info'
            )
            $('input[name=seleccionarr]').attr('checked',false);
          }
        });
    });
  });
</script>
@endsection
