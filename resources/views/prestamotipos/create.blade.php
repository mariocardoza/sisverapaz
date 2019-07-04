@extends('layouts.app')

@section('migasdepan')
<h1>
        
        <small>Tipo de préstamos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/bancos') }}"><i class="fa fa-address-card"></i> Bancos</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de tipos de préstamos</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'PrestamotiposController@store','class' => 'form-horizontal','autocomplete'=>'off']) }}
                        @include('errors.validacion')    
                        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                        <label for="nombre" class="col-md-4 control-label">Nombre</label>

                        <div class="col-md-6">
                            {{ Form::text('nombre', null,['id'=>'nom_banco','class' => 'form-control']) }}
                        </div>
                    </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {{Form::button('<span class="glyphicon glyphicon-floppy-disk"></span>Registrar',[
                                        'type' => 'submit',
                                        'class'=> 'btn btn-success',
                                    ])}}
                                </div>
                            </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
