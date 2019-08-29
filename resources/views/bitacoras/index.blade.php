<?php
use App\Bitacora;
use Carbon\Carbon; ?>
@extends('layouts.app')

@section('migasdepan')
<h1>
        Bitácora
        <small>Control de bitácora</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li class="active">Listado de bitácoras</li>
      </ol>
@endsection

@section('content')
  <div id="app-6">
    <p>@{{ message }}</p>
    <input v-model="message">
  </div>

<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding" >
              <h1>¿Qué bitácora desea ver?</h1>
              <div class="form-group">
                <label>Bitácora general</label>
                <a href="{{ url('bitacoras/general') }}" class="btn btn-primary">Ver</a>
              </div>
               <div class="form-group">
              {{ Form::open(['action' => 'BitacoraController@usuario','method' => 'get','class' => 'form-horizontal']) }}
                <label>Bitácora por usuario</label>
                <select name="usuario" class="form-control">
                  @foreach($usuarios as $usuario)
                  <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Ver</button>
            {{ Form::close() }}
             </div>
              <div class="form-group">
                <label>Bitácora por fecha</label>
                <input type="text" id="datepicker">
                <a href="{{ url('bitacoras/fecha') }}" class="btn btn-primary">Ver</a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
@endsection
