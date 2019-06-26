@extends('layouts.app')
@section('migasdepan')
<h1>
        Bancos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de Afps</li>
      </ol>
@endsection
@section('content')
<div class="row">
      <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <div class="btn-group pull-right">
                    <a id="modal_nuevo" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                    <a href="{{ url('/bancos?estado=1') }}" class="btn btn-primary">Activos</a>
                    <a href="{{ url('/bancos?estado=0') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Nombre de la afp</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($afps as $index => $afp)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $afp->nombre}}</td>
                    <td>
                      @if($afp->estado == 1 )
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                        <a href="{{ url('afps/'.$afp->id.'/edit') }}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-text-size"></span></a>
                        <button class="btn btn-danger btn-sm" type="button" onclick={{ "baja(".$afp->id.",'afps')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
                      @else
                        {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                          <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$afp->id.",'afps')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
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
      @include('afps.modales')
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function(e){
    var eltoken = $('meta[name="csrf-token"]').attr('content');
    $(document).on("click","#modal_nuevo",function(e){
      $("#modal_afp").modal("show");
    });

    $(document).on("click","#registrar_afp",function(e){
      var valid=$("#afp").valid();
      if(valid){
        var datos=$("#afp").serialize();
        $.ajax({
          url:'afps',
          headers: {'X-CSRF-TOKEN':eltoken},
          type:'post',
          dataType:'json',
          data:datos,
          success:function(json){
            if(json[0]==1){
              toastr.success("Registrado exitosamente");
            }else{
              toastr.error("Ocurrió un error, contacte al administrador");
            }
          }
        });
      }
    });
  });
</script>
@endsection
