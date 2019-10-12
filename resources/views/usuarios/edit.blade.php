@extends('layouts.app')
@section('migasdepan')
<h1>
  Modificar usuario <small> {{ $usuario->name }} </small>
</h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/usuarios') }}"><i class="fa fa-address-card"></i> Usuarios</a></li>
        <li class="active">Edición</li>
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
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registro de Usuarios</div>
                <div class="panel-body">
                	 {{ Form::model($usuario,['method' => 'put','class' => 'form-horizontal', 'route' => ['usuarios.update',$usuario->id]] )}}

                    {{-- <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}"> --}}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" readonly class="form-control" value="{{ $usuario->empleado->nombre}}" autofocus>
                                <input name="empleado_id" type="hidden" readonly class="form-control" value="{{ $usuario->empleado_id}}" autofocus>
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
                            <label for="username" class="col-md-4 control-label">Username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ $usuario->username}}" autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cargo') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Cargo</label>

                            <div class="col-md-6">
                                <select class="chosen-select-width" name="roles">
                                    @foreach($roles as $rol)
                                        @if($usuario->roleuser->role_id==$rol->id)
                                            <option selected value="{{$rol->id}}">{{$rol->description}}</option>
                                        @else
                                        <option value="{{$rol->id}}">{{$rol->description}}</option>
                                        @endif
                                    @endforeach
                                  </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk"></span>    Modificar
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
