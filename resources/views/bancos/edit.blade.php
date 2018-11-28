@extends('layouts.app')

@section('migasdepan')
<h1>
        Editar banco
        <small>{{$banco->nombre}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/bancos') }}"><i class="fa fa-address-card"></i> Bancos</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
        <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Datos del banco</div>     
            <div class="panel-body">
                {!!Form::model($banco,['class' =>'form-horizontal','route' =>['bancos.update',$banco->id],'method' =>'PUT','autocomplete'=>'off'])!!}
                @include('errors.validacion')      
                @include('bancos.formulario')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{Form::button('<span class="glyphicon glyphicon-floppy-disk"></span>Editar',[
                                'type' => 'submit',
                                'class'=> 'btn btn-primary',
                             ])}}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
