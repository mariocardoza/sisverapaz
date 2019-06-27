@extends('layouts.app')

@section('migasdepan')
<h1>
   &nbsp; 
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proveedores') }}"><i class="fa fa-user-circle-o"></i> Proveedores</a></li>
        <li class="active">Ver proveedor</li>
      </ol>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">Datos del Proveedor </div>
            <div class="panel-body">
              <table class="table">
                  <tr>
                    <td>Nombre</td>
                    <th>{{$proveedor->nombre}}</th>
                  </tr>
                  <tr>
                    <td>Dirección</td>
                    <th>{{$proveedor->direccion}}</th>
                  </tr>
                  <tr>
                    <td>Teléfono</td>
                    <th>{{$proveedor->telefono}}</th>
                  </tr>
                  <tr>
                    <td>E-Mail</td>
                    <th>{{$proveedor->email}}</th>
                  </tr>
                  <tr>
                    <td>NIT</td>
                    <th>{{$proveedor->nit}}</th>
                  </tr>
                  <tr>
                    <td>NRC</td>
                    <th>{{$proveedor->numero_registro}}</th>
                  </tr>
                  <tr>
                    <td>DUI (persona natural)</td>
                    <th>{{$proveedor->dui}}</th>
                  </tr>
              </table>
              <center><button id="editar" class="btn btn-primary btn sm"><i class="fa fa-edit"></i> Editar</button></center>
            </div>
          </div>
    </div>
    <div class="col-md-5">
          <div class="panel panel-primary">
            <div class="panel-heading">Datos de representante legal</div>
            <div class="panel-body">
              <?php if($proveedor->nombrer != ''): ?>
                <table class="table">
                  <tr>
                    <td>Nombre</td>
                    <th>{{$proveedor->nombrer}}</th>
                  </tr>
                  <tr>
                    <td>Celular</td>
                    <th>{{$proveedor->celular_r}}</th>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <th>{{$proveedor->emailr}}</th>
                  </tr>
                   <tr>
                    <td>Teléfono fijo</td>
                    <th>{{$proveedor->telfijor}}</th>
                  </tr>
                  <tr>
                    <td>DUI</td>
                    <th>{{$proveedor->duir}}</th>
                  </tr>
                </table>
              <?php else: ?>
                <center>
                  <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> Advertencia</h4>
                  <span>Agregue los datos del representante legal</span><br>
                  
                </center>
              <?php endif; ?>
              <center><button class="btn btn-primary" id="show_representante">Agregar</button></center>
            </div>
          </div>
    </div>
  </div>
</div>
@include('proveedores.modales')
@endsection
@section('scripts')
<script type="text/javascript">
  elproveedor='<?php echo $proveedor->id ?>';
</script>
{!! Html::script('js/proveedor.js?cod='.date('Yidisus')) !!}
@endsection
