@extends('layouts.app')

@section('migasdepan')
<h1>
        Categorías
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de categorías</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <div class="btn-group pull-right">
                  <a href="javascript:void(0)" id="btnmodalagregar" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span></a>
                  <a href="{{ url('/categorias?estado=1') }}" class="btn btn-primary">Activos</a>
                  <a href="{{ url('/categorias?estado=0') }}" class="btn btn-primary">Papelera</a>
                </div>
            </div>
            <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
              <tr>
                <th>N°</th>
							<th>Nombre categoría</th>
							<th>Acción</th>
              </tr>
					</thead>
					<tbody>
						@foreach($categorias as $key => $categoria)
						<tr>
              <td>{{ $key+1}}</td>
							<td>{{ $categoria->nombre_categoria}}</td>
              <td>
                  @if($categoria->estado == 1 )
                  {{ Form::open(['method' => 'POST', 'class' => 'form-horizontal baja'])}}
                    <a href="javascript:(0)" id="edit" data-id="{{$categoria->id}}" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>
                    <button class="btn btn-danger btn-sm" type="button" onclick={{ "baja(".$categoria->id.",'categorias')" }}><span class="glyphicon glyphicon-trash"></span></button>
                  {{ Form::close()}}
                @else
                  {{ Form::open(['method' => 'POST','class' => 'form-horizontal alta'])}}
                    <button class="btn btn-success btn-sm" type="button" onclick={{ "alta(".$categoria->id.",'categorias')" }}><span class="glyphicon glyphicon-trash"></span></button>
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

@include("categorias.modales")
@endsection

@section("scripts")
<script type="text/javascript">
  $(document).ready(function(e){
    $(document).on("click", "#btnmodalagregar",function(e){
        $("#md_categoria").modal("show");
      });

    $(document).on("click", "#registrar_categoria", function(e){
      modal_cargando();
      e.preventDefault();
      var datos = $("#form_categoria").serialize();
      $.ajax({
        url:"categorias",
        type:"post",
        data:datos,
        success:function(json){
          console.log(json);
          if(json.mensaje=='exito'){
            toastr.success("Registrado con éxito");
            $("#md_categoria").modal("hide");
            window.location.reload();
            swal.closeModal();
          }
          else{
            toastr.error("Falló");
            swal.closeModal();
          }
        },
        error:function(error){
          swal.closeModal();
          $(error.responseJSON.errors).each(function(index,valor){
            toastr.error(valor.nombre_categoria);
          });
        }
      });
    });
  });
</script>
@endsection