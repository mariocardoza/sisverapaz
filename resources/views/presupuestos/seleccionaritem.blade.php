@extends('layouts.app')

@section('migasdepan')
<h1>
        Presupuestos
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proyectos') }}"><i class="fa fa-industry"></i> Proyectos</a></li>
        <li class="active">Presupuestos</li>
      </ol>
@endsection
@section('content')
  <div class="container">
<div class="row">
<div class="col-md-11">


              <div class="panel panel-primary">
                  <div class="panel-heading">Registro de presupuesto</div>
                  <div class="panel-body">
                    {{ Form::open(['action' => 'PresupuestoController@crear','method'=>'get','class' => 'form-horizontal','id' => 'presupuesto']) }}

              <div class="form-group">
                <label for="" class="col-md-4">Proyecto</label>
                  <div class="col-md-6">

                      {!!Form::hidden('proyecto_id',$proyecto->id,['id' => 'proyecto'])!!}
                      {!!Form::textarea('',$proyecto->nombre,['class' => 'form-control','readonly','rows'=>3])!!}

                  </div>
              </div>
            <br>
              <div class="form-group">
                  <label for="" class="col-md-4">Ítem</label>
                  <div class="col-md-6" id="select">
                      <select name="item" id="item" required class="chosen-select-width">
                          <option value="">Seleccione un ítem</option>
                      </select>
                  </div>
                  <div class="col-md-2">
                      <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalcategoria"><span class="glyphicon glyphicon-plus"></span></button>
                  </div>
              </div>
              <button type="submit"  class="btn btn-primary">Siguiente</button>
              {{Form::close()}}
            </div>
          </div>
          </div>
        </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalcategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Ingreso de ítem
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="" class="col-md-4">Digite el ítem</label>
                        <div class="col-md-6">
                          {!!Form::text('',null,['class' => 'form-control','id'=>'txtitem'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-4">Digite la categoría</label>
                        <div class="col-md-6">
                            <input type="text" id="txtcategoria" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardaritem" data-dismiss="modal" class="btn btn-success">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/presupuestos.js') !!}
@endsection
