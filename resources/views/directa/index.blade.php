@extends('layouts.app')

@section('migasdepan')
<h1>
        Compras directas
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/directa') }}"><i class="fa fa-dashboard"></i> Compras</a></li>
        <li class="active">Listado de compras</li>
      </ol>
@endsection

@section('content')
<style>
  .modal {
    position:absolute;
    overflow:scroll;
}

</style>
@php
    $cuentas=[];
    $cuentas=App\Cuenta::whereEstado(1)->get();
@endphp
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3><br>
                <a href="javascript:void(0)" id="nuevo" class="btn btn-success pull-right"><span class="fa fa-plus-circle"></span></a>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Código</th>
                  <th>Nombre del proceso</th>
                  <th>Renta</th>
                  <th>Total</th>
                  <th>Usuario</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach ($compras as $i=>$c)
                      <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$c->codigo}}</td>
                        <td>{{$c->nombre}}</td>
                        <td class="text-right">${{number_format($c->renta,2)}}</td>
                        <td class="text-right">${{number_format($c->monto,2)}}</td>
                        <td>{{$c->user->empleado->nombre}}</td>
                        <td>
                          <div class="btn-group">
                            <a href="{{url('directa/'.$c->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                            <a href="javascript:void(0)" class="btn btn-warning editar" data-id="{{$c->id}}"><i class="fa fa-edit"></i></a>
                          </div>
                        </td>
                      </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
<div class="modal fade" tabindex="-1" id="modal_nuevo" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar una compra</h4>
      </div>
      <div class="modal-body">
          <form id="form_compra" class="">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="" class="control-label">Nombre del proceso</label>
                    <input type="text" name="nombre" class="form-control">
                  </div>
                 
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label">Número de la compra</label>
                    <input type="text" class="form-control" name="numero_proceso">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="" class="control-label">Cuenta</label>
                    <select name="cuenta_id" id="" class="chosen-select-width">
                      <option value="">Seleccione</option>
                      @foreach ($cuentas as $c)
                          <option value="{{$c->id}}">{{$c->nombre}}<option>
                      @endforeach
                    </select>
                  </div>
                </div>
                
                <!--div class="col-md-12">
                  <label for="">¿El proceso lleva impuesto sobre la renta?</label>
                  <input type="checkbox" class="renta">
                </div>
                <div class="col-md-6 sirenta" style="display: none;">
                  <label for="" class="control-label">Renta</label>
                  <input type="number" step="any" name="renta"  value="0" class="form-control larenta">
                </div>
                <div class="col-md-6 sirenta" style="display: none;">
                  <label for="" class="control-label">Total</label>
                  <input type="number" name="total" readonly class="form-control total">
                </div-->
            </div>
          
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>

<div id="modal_aqui"></div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(e){
        $(document).on("click","#nuevo",function(e){
            e.preventDefault();
            $("#modal_nuevo").modal("show");
        });

        //lleva renta?
        $(document).on("change",".renta",function(e){
          e.preventDefault();
          if( $(this).prop('checked') ) {
            $(".sirenta").show();
            $(".larenta").val("");
          }else{
            $(".sirenta").hide();
            $(".larenta").val(0);
            let monto=0;
            monto=parseFloat($(".elmonto").val());
            $(".total").val(monto);
          }
        });

        


        $(document).on("input",".elmonto,.larenta",function(e){
          e.preventDefault();
          let valor=0;
          let renta=0;
          let total=0;
          renta=parseFloat($(".larenta").val());
          valor=parseFloat($(".elmonto").val());
          total=valor-renta;
          $(".total").val(total.toFixed(2));
        });

        $(document).on("click",".editar",function(e){
          e.preventDefault();
          var id=$(this).attr("data-id");
          $.ajax({
            url:'directa/modaledit/'+id,
            type:'get',
            dataType:'json',
            success: function(json){
              if(json[0]==1){
                $("#modal_aqui").empty();
                $("#modal_aqui").html(json[1]);
                $("#modal_edit").modal("show");
              }else{
                toastr.error("Ocurrió un error en el servidor");
              }
            },
            error: function(e){
              toastr.error("Ocurrió un error en el servidor");

            }
          });
        });

        //editar
        $(document).on("click",".puteditar", function(e){
          e.preventDefault();
          var id=$(this).attr("data-id");
          var datos=$("#form_ecompra").serialize();
          modal_cargando();
          $.ajax({
            url:'directa/'+id,
            type:'put',
            dataType:'json',
            data:datos,
            success:function(json){
              if(json[0]==1){
                toastr.success("Editado con éxito");
                location.reload();
              }else{
                toastr.error("Ocurrió un error en el servidor");
                swal.closeModal();
              }
            }, error: function(error){
              $.each(error.responseJSON.errors,function(i,v){
                toastr.error(v);
              });
              swal.closeModal();
            }
          })
        });

        //submit
        $(document).on("submit","#form_compra",function(e){
          e.preventDefault();
          var datos=$("#form_compra").serialize();
          modal_cargando();
          $.ajax({
            url:'directa',
            type:'post',
            dataType:'json',
            data:datos,
            success:function(json){
              if(json[0]==1){
                toastr.success("Registrado con éxito");
                location.reload();
              }else{
                toastr.error("Ocurrió un error en el servidor");
                swal.closeModal();
              }
            }, error: function(error){
              $.each(error.responseJSON.errors,function(i,v){
                toastr.error(v);
              });
              swal.closeModal();
            }
          });
        });
    });
</script>
@endsection