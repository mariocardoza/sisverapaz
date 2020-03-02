@extends('layouts.app')

@section('migasdepan')
<h1>
        Empleados
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/empleados') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Listado de empleados</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
                <div class="btn-group pull-right">
                  <a href="javascript:void(0)" id="btn_n_empleado" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                  <a href="{{ url('/empleados?estado=1') }}" class="btn btn-primary">Activos</a>
                  <a href="{{ url('/empleados?estado=2') }}" class="btn btn-primary">Inactivos</a>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
                <thead>
                  <th>N°</th>
                  <th>Nombre empleado</th>
                  <th>DUI</th>
                  <th>Celular</th>
                  <th>Dirección</th>
                  <th>Acción</th>
                </thead>
                <tbody>
                  @foreach($empleados as $index => $empleado)
                  <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->dui }}</td>
                    <td>{{ $empleado->celular }}</td>
                    <td>{{ $empleado->direccion }}</td>
                    
                    <td>
                      @if($estado == 1 || $estado == "")
                        {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal'])}}
                          <a href="{{ url('empleados/'.$empleado->id) }}" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <button class="btn btn-danger" type="button" onclick={{ "baja(".$empleado->id.",'empleados')" }}><span class="glyphicon glyphicon-trash"></span></button>

                      

                        {{ Form::close()}}
                      @else
                        {{ Form::open(['method' => 'POST',  'class' => 'form-horizontal'])}}
                          <button class="btn btn-success" type="button" onclick={{ "alta(".$empleado->id.",'empleados')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
                      @endif
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
<div class="modal fade" tabindex="-1" id="modal_empleado" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="gridSystemModalLabel">Registrar nuevo empleado</h4>
      </div>
      <div class="modal-body">
      	<form id="fm_empleado" type="post">
      		@include('empleados.formulario')
      	
      </div>
      <div class="modal-footer">
        <center><button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <button type="submit"  class="btn btn-success">Registrar</button></center>
      </div>
    </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function(e){
    //abrir modal para registrar empleado
    $(document).on("click","#btn_n_empleado",function(e){
      $("#modal_empleado").modal("show");
    });

    //registrar empleado
    $(document).on("submit","#fm_empleado",function(e){
      e.preventDefault();
      var datos=$("#fm_empleado").serialize();
      $.ajax({
        url:'empleados',
        type:'POST',
        dataType:'json',
        data:datos,
        success: function(json){
          if(json[0]==1){
            toastr.success("Empleado registrado con éxito");
            location.reload();
          }else{

          }
        },
        error: function(error){
          $.each(error.responseJSON.errors,function(index,value){
	          		toastr.error(value);
	          	});
	          	swal.closeModal();
        }
      });
    });
  });
</script>
@endsection