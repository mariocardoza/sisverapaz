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
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3><br>
                <a href="javascript:void(0)" id="nuevo" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Decl. Emergencia</th>
                  <th>Motivo</th>
                  <th>Código</th>
                  <th>Número de compra</th>
                  <th>Nombre del proceso</th>
                  <th>Monto</th>
                  <th>Usuario</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach ($compras as $i=>$c)
                      <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$c->emergencia->numero_acuerdo}}</td>
                        <td>{{$c->emergencia->detalle}}</td>
                        <td>{{$c->codigo}}</td>
                        <td>{{$c->numero_proceso}}</td>
                        <td>{{$c->nombre}}</td>
                        <td class="text-right">${{number_format($c->monto,2)}}</td>
                        <td>{{$c->user->empleado->nombre}}</td>
                        <td>
                          <a href="{{url('directa/'.$c->id)}}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                          <a href="javascript:void(0)" class="btn btn-warning editar" data-id="{{$c->id}}"><i class="fa fa-edit"></i></a>
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
  <div class="modal-dialog modal-sm" role="document">
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
                    <label for="" class="control-label">Número de la compra</label>
                    <input type="text" class="form-control" name="numero_proceso">
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">Nombre del proceso</label>
                    <input type="text" name="nombre" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="" class="control-label">Monto</label>
                    <input type="number" name="monto" class="form-control">
                  </div>
                </div>
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
              swal:closeModal();
            }
          })
        })

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