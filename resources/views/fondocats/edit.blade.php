@extends('layouts.app')

@section('migasdepan')
<h1>
        Categoría: {{ $fondocat->categoria }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/fondocats') }}"><i class="fa fa-dashboard"></i> Categorías de fondos</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">       
            <div class="panel-body">
                {{ Form::model($fondocat, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('fondocats.update', $fondocat->id))) }} 
                 @include('fondocats.formulario')
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-primary btn-lg">
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
