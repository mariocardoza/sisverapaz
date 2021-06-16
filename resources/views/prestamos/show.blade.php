@extends('layouts.app')

@section('migasdepan')
<h1>
<p><small>Préstamo de <b>{{ $prestamo->empleado->nombre }}</b></small></p>
        
        <p></p>
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
                <div class="panel-heading">Datos del Préstamo </div>
                <div class="panel-body">
                    <p></p>
                        <div class="form-group{{ $errors->has('empleado') ? ' has-error' : '' }}">
                            <label for="nombre" class="col-md-4 control-label">Empleado: </label>
                            <label for="nombre" class="col-md-4 control-label">{{$prestamo->empleado->nombre}}</label><br>

                        </div>

                         <div class="form-group{{ $errors->has('banco') ? ' has-error' : '' }}">
                            <label for="dui" class="col-md-4 control-label">Banco: </label>
                            <label for="nombre" class="col-md-4 control-label"> {{$prestamo->banco->nombre}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('numero_cuenta') ? ' has-error' : '' }}">
                            <label for="nit" class="col-md-4 control-label">Número Cuenta:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$prestamo->numero_de_cuenta}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
                            <label for="sexo" class="col-md-4 control-label">Monto del Préstamo:</label>
                            <label for="nombre" class="col-md-4 control-label">$ {{number_format($prestamo->monto,2)}}</label><br>
                        </div>

                        <div class="form-group{{ $errors->has('numero_cuotas') ? ' has-error' : '' }}">
                            <label for="telefono_fijo" class="col-md-4 control-label">Número de Cuotas:</label>
                            <label for="nombre" class="col-md-4 control-label">{{$prestamo->numero_de_cuotas}}</label><br>

                        </div>

                        <div class="form-group{{ $errors->has('cuota') ? ' has-error' : '' }}">
                            <label for="celular" class="col-md-4 control-label">Cuota a Pagar:</label>
                            <label for="nombre" class="col-md-4 control-label">$ {{number_format($prestamo->cuota,2)}}</label><br>
                        </div>
                        <p></p>
                        <p><a href="{{ url('prestamos/'.$prestamo->id.'/edit') }}" class="btn btn-warning"><span class=""></span> Editar</a></p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
