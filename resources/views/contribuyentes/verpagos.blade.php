@extends('layouts.app')

@section('migasdepan')
<h1>
        Pagos
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('/contribuyentes') }}"><i class="fa fa-home"></i> Contribuyentes</a></li>
        <li><a href="{{ url('/contribuyentes/pagos/'.$inmueble->contribuyente->id) }}"><i class="fa fa-money"></i> Pagos </a></li>
        <li class="active">pago del inmueble</li>
      </ol>
@endsection

@section('content')
<div class="panel">
    <div class="row">
        <div class="col-md-12">
          <div class="page-header" style="overflow: hidden;">
            <div class="pull-left">
              <i class="fa fa-user"></i> {{$inmueble->contribuyente->nombre}}<br />
              <small style="margin-top: 0px; margin-left: 28px">Cuenta N°: {{$inmueble->numero_cuenta}}</small>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <a href="{{ url('/contribuyentes/pagos/'.$inmueble->contribuyente->id) }}" class="btn btn-primary pull-right">Atrás</a>
        </div>
      </div>

      <div class="row">
        <div class="invoice-info" >   
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b># Catastral:</b> {{$inmueble->numero_catastral}}<br>
              <b>N° de escritura:</b> {{$inmueble->numero_escritura}}<br>
              <b>Medida (Ancho x largo):</b> {{$inmueble->ancho_inmueble }}x {{$inmueble->largo_inmueble}} mts.}<br>
              <b>Metros de acera:</b> {{number_format($inmueble->metros_acera,2)}}<br>
             </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
             <b>Dirección: </b>      
              <address>
                {{$inmueble->direccion_inmueble}}
              </address><br>
            </div>
          </div>
      </div>

      <div class="row" style="clear:both;padding-top:30px;">
        <div class="active tab-pane" id="inmuebles" style="max-height: 580px; overflow-y: scroll; overflow-y: auto;">
            <div class="col-xs-12 table-responsive" style="padding-top: 30px;">
                <table class="table no-margin">
                  <thead>
                    <tr>
                      <th class="text-center">Periodo</th>
                      <th class="text-center">Fecha vencimiento</th>
                      <th class="text-center">subtotal</th>
                      <th class="text-center">Fiestas</th>
                      <th class="text-center">Total a pagar</th>
                      <th class="text-center">Referencia</th>
                      <th class="text-center">Estado</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($inmueble->factura as $i)
                    <tr>
                        <td class="text-center">{{$i->mesYear}}</td>
                        <td class="text-center">
                        @if($i->fechaVencimiento<date('Y-m-d'))   
                            <span class="label label-danger">{{$i->fechaVencimiento->format('d/m/Y')}}</span>
                        @else
                            <span class="label label-success">{{$i->fechaVencimiento->format('d/m/Y')}}</span>
                        @endif
                        </td>
                        <td class="text-right">${{number_format($i->pagoTotal,2) }}</td>
                        <td class="text-right">${{number_format($i->pagoTotal*$i->porcentajeFiestas/100,2) }}</td>
                        <td class="text-right">${{number_format($i->pagoTotal+($i->pagoTotal*$i->porcentajeFiestas/100),2) }}</td>
                        <td class="text-center">{{$i->codigo}}</td>
                        <td class="text-center">
                          @if($i->estado==1)
                          <span class="label label-danger">
                            Pendiente
                          </span>
                          @else 
                          <span class="label label-success">
                            Cancelado
                          </span>
                          @endif
                        </td>
                        <td class="text-center">
                          <div class="btn-group text-align">
                            
                            <a class="btn btn-success ver pagos" href="{{url('verfacturaspendientes?cbid='.$i->id)}}" data-id="{{$i->id}}" target="_blank">
                              <i class="fa fa-fw fa-print"></i>
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
@endsection

@section('scripts')

@endsection
