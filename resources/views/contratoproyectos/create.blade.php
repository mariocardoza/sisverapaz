@extends('layouts.app')

@section('migasdepan')
<h1>
        Generalidades del contrato del proyecto

      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/contratoproyectos') }}"><i class="fa fa-dashboard"></i> Contrato</a></li>
        <li class="active">Registro</li>      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de contrato</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'ContratoproyectoController@store','class' => 'form-horizontal']) }}
                        @include('errors.validacion')
                        @include('contratoproyectos.formulario')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk"></span>    Registrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('contratoproyectos.modales')
@section('scripts')
{!! Html::script('js/contratoproyecto.js') !!}
@endsection
