@extends('layouts.app')

@section('migasdepan')
<h1>
        Editar detalle
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/presupuestos') }}"><i class="fa fa-user-circle-o"></i> Presupuestos</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
          <div class="panel-heading">Edición de presupuesto</div>
            <div class="panel-body">
                {{ Form::model($detalle, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('presupuestodetalles.update', $detalle->id))) }}
                 @include('presupuestos.detalle.formularioedit')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-warning">
                                <span class="fa fa-edit"></span>    Editar
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
