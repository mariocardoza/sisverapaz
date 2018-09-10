@extends('layouts.app')

@section('migasdepan')
<h1>
        Categoría: {{ $categoriatrabajo->categoria }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/categoriatrabajos') }}"><i class="fa fa-dashboard"></i> Categorías de trabajos</a></li>
        <li class="active">Edición</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">       
            <div class="panel-body">
                {{ Form::model($categoriatrabajo, array('method' => 'put', 'class' => 'form-horizontal' , 'route' => array('categoriatrabajos.update', $categoriatrabajo->id))) }} 
                 @include('categoriatrabajos.formulario')
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
