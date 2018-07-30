@extends('layouts.app')

@section('migasdepan')
<h1>
        Categorías
        <small>Control de categorías</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/categorias') }}"><i class="fa fa-dashboard"></i> Categorías</a></li>
        <li class="active">Listado de categorías</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
                <a href="{{ url('/categorias/create') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
                <a href="{{ url('/categorias?estado=1') }}" class="btn btn-primary">Activos</a>
                <a href="{{ url('/categorias?estado=2') }}" class="btn btn-primary">Papelera</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <tr>
							<th>Item</th>
							<th>Nombre categoría</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						@foreach($categorias as $categoria)
						<tr>
							<td>{{ $categoria->item}}</td>
							<td>{{ $categoria->nombre_categoria}}</td>
							<td>
                    
                    <td>
						@if($categoria->estado == 1)
                        {{ Form::open(['method' => 'POST', 'id' => 'baja', 'class' => 'form-horizontal'])}}
                          <a href="{{ url('categorias/'.$categoria->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-eye-open"></span></a>
                          <a href="{{ url('categorias/'.$categoria->id.'/edit') }}" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-text-size"></span></a>
                          <button class="btn btn-danger btn-xs" type="button" onclick={{ "baja(".$categoria->id.",'categorias')" }}><span class="glyphicon glyphicon-trash"></span></button>
                        {{ Form::close()}}
                      @else
                        {{ Form::open(['method' => 'POST', 'id' => 'alta', 'class' => 'form-horizontal'])}}
                          <button class="btn btn-success btn-xs" type="button" onclick={{ "alta(".$categoria->id.",'categorias')" }}><span class="glyphicon glyphicon-trash"></span></button>
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
</div>
@endsection
