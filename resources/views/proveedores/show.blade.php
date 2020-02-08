@extends('layouts.app')

@section('migasdepan')
<h1>
   Perfil del proveedor
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
        <li><a href="{{ url('/proveedores') }}"><i class="fa fa-user-circle-o"></i> Proveedores</a></li>
        <li class="active">Perfil</li>
      </ol>
@endsection

@section('content')
<div class="">
  <div class="row">
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-body box-profile">
        <img class="profile-user-img img-responsive img-circle" src="{{ url('img/proveedor.png')}}" alt="User profile picture">

          <h3 class="profile-username text-center">{{$proveedor->nombre}}</h3>
          @if($proveedor->giro_id!='')
          <p class="text-muted text-center">{{$proveedor->giro->nombre}}</p>
          @endif
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>{{$proveedor->direccion}}</b>
            </li>
            <li class="list-group-item">
              <b>Teléfono: </b>{{$proveedor->telefono}}
            </li>
            <li class="list-group-item">
              <b>{{$proveedor->email}}</b> 
            </li>
            <li class="list-group-item">
              <b>NIT: </b>{{$proveedor->nit}} 
            </li>
            <li class="list-group-item">
              <b>NRC: </b>{{$proveedor->numero_registro}} 
            </li>
            <li class="list-group-item">
              <b>DUI: </b>{{$proveedor->dui}} 
            </li>
          </ul>

          <a href="javascript:void(0)" id="editar" class="btn btn-primary btn-block"><b>Editar</b></a>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-9">
      <div class="nav-tabs-custom" style=" ">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#activity" data-toggle="tab">Actividad</a></li>
          <li><a href="#timeline" data-toggle="tab">Representante legal</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
            @forelse ($proveedor->cotizacion as $c)
            <div class="post">
              <div class="user-block">
                <img class="img-circle img-bordered-sm" src="{{url('img/cotizacion.png')}}" alt="user image">
                    <span class="username">
                      <a target="_blank" href="{{url('reportesuaci/solicitud/'.$c->solicitudcotizacion->id)}}">Solicitud número: {{$c->solicitudcotizacion->numero_solicitud}}</a>
                      <a href="#" class="pull-right btn-box-tool"><i class="fa fa-time"></i></a>
                    </span>
                <span class="description">Publicada el: - {{$c->solicitudcotizacion->created_at->format('d/m/Y H:i')}}</span>
              </div>
              <!-- /.user-block -->
              <p>
                La presente cotización corresponde 
                @if($c->solicitudcotizacion->tipo==2)
                a la actividad: <b>{{$c->solicitudcotizacion->requisicion->actividad}}</b>
                @else
                al proyecto: <b>{{$c->solicitudcotizacion->proyecto->actividad}}</b>
                @endif
                haciendo un total de <b>${{\App\Cotizacion::total_cotizacion($c->id)}}</b>;
                con una forma de pago de: <b>{{$c->formapago->nombre}}</b>
              </p>
              <ul class="list-inline">
                <li><a href="#" class="link-black text-sm"><i class="fa fa-share margin-r-5"></i> Ver cotización</a></li>
                @if($c->seleccionado==1)
                <li style="color:green;"><a href="javascript:void(0)" class="link-black text-sm"><i style="color: green;" class="fa fa-thumbs-o-up margin-r-5"></i> Cotización aprobada</a>
                </li>
                @else
                <li><a style="color:red;" href="javascript:void(0)" class="link-black text-sm"><i style="color: red;" class="fa fa-thumbs-o-down margin-r-5"></i> Cotización rechazada</a>
                </li>
                @endif
               
              </ul>
            </div>
            @empty
            <center>
              <h4 class="text-yellow"><i class="glyphicon glyphicon-warning-sign"></i> No existen registros</h4>
              <span>No se ha registrado ninguna cotización para este proveedor</span><br>
            </center>
            @endforelse
            <!-- Post -->
            
            <!-- /.post -->
            <!-- /.post -->
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="timeline">
            
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
          <!-- /.tab-pane -->

          
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
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
