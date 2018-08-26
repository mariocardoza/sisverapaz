@extends('layouts.app')

@section('migasdepan')
<h1>
Editar <small>{{$requisicion->descripcion}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/requisiciones') }}"><i class="fa fa-balance-scale"></i> Requisiciones</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
          <div class="panel-heading">Edicion de requisición</div>
            <div class="panel-body">
                {{ Form::model($requisicion, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('requisiciones.update', $requisicion->id))) }}
                @include('requisiciones.formulario')



                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-floppy-disk"></span>    Editar
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
