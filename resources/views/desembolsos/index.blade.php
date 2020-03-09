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
                  <th>Fecha desembolso</th>
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

                    @if($desembolso->fecha_desembolso!= '')
                    <td>{{ $desembolso->fecha_desembolso->format('d/m/Y') }}</td>

                    @else
                    <td>-</td>
                    @endif

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

<div class="modal fade" tabindex="-1" id="modal_desembolso" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar desembolso</h4>
      </div>
      <div class="modal-body">
        <form id="form_desembolso" action="" class="">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">Número de cheque</label>
                <input type="text" name="numero_cheque" class="form-control">
              </div>
              <div class="form-group">
                <label class="control-label">Fecha</label>
                <input type="text" name="fecha_desembolso" class="form-control fechita">
                <input type="hidden" name="id" id="fila">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="guarda_desembolso">Aceptar</button>
      </div>
    </div>
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
      $('#modal_desembolso').modal('show');
      $("#fila").val(id);
    });

    //////FUNCION CLICK PARA GUARDAR DESEMBOLSO
    $(document).on("click",'#guarda_desembolso', function(e){
      e.preventDefault();
      var datos=$("#form_desembolso").serialize();
      //console.log(datos);
      $.ajax({
        url: 'desembolsos',
        type: 'POST',
        dataType: 'json',
        data: datos,
        success: function(json)
        {
          if(json[0]==1)
          {
            toastr.success("Desembolso realizado");
            location.reload();
          }
          else {
            if(json[0]==2)
            {
              toastr.info(json[2]);
            }
            else{
              toastr.error("Falló");
            }
          }
        },
        error: function(error)
        {
          
        }
      });
    });
  });
</script>
@endsection
