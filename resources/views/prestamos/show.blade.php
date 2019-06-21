@extends('layouts.app')

@section('migasdepan')
<h1>

        <small>Ver préstamo <b>{{ $prestamo->empleado->nombre }}</b></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/prestamos') }}"><i class="fa fa-dashboard"></i> Préstamos</a></li>
        <li class="active">Ver</li>
      </ol>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-11">
            <div class="panel panel-primary">
                <div class="panel-heading">Datos del préstamo </div>
                <div class="panel-body">
                        <div class="form-group{{ $errors->has('empleado') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Nombre del empleado: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$prestamo->empleado->nombre}}</label><br>

                        </div>

                         <div class="form-group{{ $errors->has('banco') ? ' has-error' : '' }}">
                            <label for="dui" class="col-md-4 control-label">Nombre del banco: </label>
                            <label for="nombre" class="col-md-4 control-label"> {{$prestamo->banco->nombre}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('numero_cuenta') ? ' has-error' : '' }}">
                            <label for="nit" class="col-md-4 control-label">Número de cuenta:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$prestamo->numero_de_cuenta}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
                            <label for="sexo" class="col-md-4 control-label">Monto del ´préstamo:</label>
                            <label for="nombre" class="col-md-4 control-label">$ {{number_format($prestamo->monto,2)}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('numero_cuotas') ? ' has-error' : '' }}">
                            <label for="telefono_fijo" class="col-md-4 control-label">Número de cuotas:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$prestamo->numero_de_cuotas}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('cuota') ? ' has-error' : '' }}">
                            <label for="celular" class="col-md-4 control-label">Cuota a pagar:</label>
                            <label for="nombre" class="col-md-4 control-label">$ {{number_format($prestamo->cuota,2)}}</label><br>
                        </div>
                      <a href="{{ url('prestamos/'.$prestamo->id.'/edit') }}" class="btn btn-warning"><span class="glyphicon glyphicon-text-size"></span> Editar</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
