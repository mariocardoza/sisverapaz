@extends('layouts.app')

@section('migasdepan')
<h1>
        Usuarios
        <small>Control de Usuarios</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/usuarios') }}"><i class="fa fa-address-card"></i> Usuarios</a></li>
        <li class="active">Registro</li>
      </ol>
@endsection

@section('content')
@php
    $unid=App\Unidad::where('estado',1)->get();
    $unidades=[];
    foreach ($unid as $u ) {
        $unidades[$u->id]=$u->nombre_unidad;
    }
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Usuarios</div>
                <div class="panel-body">
                    {{ Form::open(['action' => 'UsuarioController@store','class' => 'form-horizontal']) }}
                        @include('errors.validacion')
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre</label>
        
                            <div class="col-md-6">
                              <select class="chosen-select-width" name="name">
                                <option value="">Seleccione</option>
                                @foreach ($empleados as $contrato)
                                  <option value="{{$contrato->id}}">{{$contrato->nombre}}</option>
                                @endforeach
                              </select>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unidad_id" class="col-md-4 control-label">Unidad</label>
                            <div class="col-md-6">
                                {!! Form::select('unidad_id',$unidades,null,['class'=>'chosen-select-width','placeholder'=>'Seleccione una unidad administrativa']) !!}
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Nombre de Usuario</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" >

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Rol del usuario</label>

                            <div class="col-md-6">
                                <select class="chosen-select-width" name="roles">
                                  @foreach($roles as $rol)
                                    <option value="{{$rol->id}}">{{$rol->description}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
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
