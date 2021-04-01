@extends('layouts.app')

@section('migasdepan')
<h1>
        Pagos
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('/contribuyentes') }}"><i class="fa fa-home"></i> Contribuyentes</a></li>
        <li class="active">pagos</li>
      </ol>
@endsection

@section('content')
<div class="panel">
    <div class="row">
        <div class="col-md-12">
          <div class="page-header" style="overflow: hidden;">
            <div class="pull-left">
              <i class="fa fa-user"></i> {{$c->nombre}}<br />
              <small style="margin-top: 0px; margin-left: 28px">DUI: {{$c->dui}}</small>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="invoice-info" >   
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>NIT:</b> {{$c->nit}}<br>
              <b>Teléfono:</b> {{$c->telefono}}<br>
              <b>Género:</b> {{$c->sexo}}<br>
              <b>Edad:</b> {{$c->nacimiento->age}}<br>
              <b>Fecha de nacimiento:</b> {{$c->nacimiento->format("d/m/Y")}}<br>
             </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
             <b>Dirección: </b>      
              <address>
                {{$c->direccion}}
              </address><br>
              @if($c->estado==2)
              <b>Contribuyente desabilitado el: </b> {{$c->fechabaja->format("d/m/Y")}}<br>
              <b>Por: </b> {{$c->motivo}} <br>
              @endif
            </div>
          </div>
      </div>
      <h4 class="text-center">Inmuebles</h4>
      <div class="row" style="clear:both;padding-top:10px;">
        <div class="active tab-pane" id="inmuebles" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
            <div class="col-xs-12 table-responsive" style="padding-top: 10px;">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th class="text-center"># Catastral</th>
                      <th class="text-center"># Escritura</th>
                      <th class="text-center">Medida (Ancho x largo)</th>
                      <th class="text-center">Metro Acera</th>
                      <th class="text-center">Estado</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($c->inmuebles as $i)
                    <tr>
                        <td class="text-center">{{$i->numero_catastral}}</td>
                        <td class="text-center"><span class="label label-success">{{$i->numero_escritura}}</span></td>
                        <td class="text-center">{{$i->ancho_inmueble }}x {{$i->largo_inmueble}} mts.</td>
                        <td class="text-center">{{number_format($i->metros_acera,2)}}</td>
                        <td class="text-center">
                          @if($i->estado==1)
                          <span class="label label-success">
                            Activo
                          </span>
                          @else 
                          <span class="label label-danger">
                            Inactivo
                          </span>
                          @endif
                        </td>
                        <td class="text-center">
                          <div class="btn-group text-align">
                            
                            <a class="btn btn-success ver pagos" href="{{url('contribuyentes/verpagos/'.$i->id)}}" data-id="{{$i->id}}">
                              <i class="fa fa-fw fa-dollar"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                          <td colspan="5"><p>No hay registros</p></td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
        </div>
      </div>
      <h4 class="text-center">Negocios</h4>
      <div class="row" style="clear:both;padding-top:10px;">
        <div class="active tab-pane" id="inmuebles" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
            <div class="col-xs-12 table-responsive" style="padding-top: 10px;">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th class="text-center">Nombre del negocio</th>
                      <th class="text-center">Rubro</th>
                      <th class="text-center">Capital</th>
                      <th class="text-center">Estado</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($c->negocios as $n)
                    <tr>
                      <td class="text-center">{{$n->nombre}}</td>              
                      <td class="text-center"><span class="label label-success">{{$n->rubro->nombre}}</span></td>
                      <td class="text-center">${{number_format($n->capital,2)}}</td>
                      <td class="text-center">
                          @if($i->estado==1)
                          <span class="label label-success">
                            Activo
                          </span>
                          @else 
                          <span class="label label-danger">
                            Inactivo
                          </span>
                          @endif
                        </td>
                        <td class="text-center">
                          <div class="btn-group text-align">
                            
                            <a class="btn btn-success ver pagos" href="{{url('contribuyentes/verpagosn/'.$i->id)}}" data-id="{{$i->id}}">
                              <i class="fa fa-fw fa-dollar"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                          <td colspan="5"><p>No hay registros</p></td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
        </div>
      </div>
</div>
<div id="modal_aqui"></div>
@include('contribuyentes.modales')
@endsection

@section('scripts')

<script>
  
  var elid='<?php echo $c->id ?>'
  

</script>
@endsection
