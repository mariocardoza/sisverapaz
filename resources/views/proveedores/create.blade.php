@extends('layouts.app')

@section('migasdepan')
<h1>
        Proveedor
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proveedores') }}"><i class="fa fa-user-circle-o"></i> Proveedores</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
            <div class="panel-heading">Registro de proveedor</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'ProveedorController@store','class' => '']) }}
                        @include('proveedores.formulario')
                        @include('errors.validacion')
                        <div class="form-group">
                            <div class="">
                                <center><button type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-floppy-disk"></span>    Registrar
                                </button></center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
@endsection
