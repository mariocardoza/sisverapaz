@extends('layouts.app')

@section('migasdepan')
<h1>
        Recibos de inmuebles
        <small>Control de recibos</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li class="active">Recibos</li>
      </ol>
@endsection

@section('content')
<div class="row">
<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped table-bordered table-hover" id="example2">
          <thead>
                  <th>N°</th>
                  <th>Propietario</th>
                  <th>N° Catastral/Inmueble</th>
                  <th>Periodo</th>
                  <th>Fecha de vencimiento</th>
                  <th>Pago</th>
                  <th>Estado</th>
                </thead>
                <tbody>
                  @foreach($facturas as $i => $f)
                  <tr>
                    <td>{{ $i+1}}</td>
                    <td>{{$f->inmueble->contribuyente->nombre}}</td>
                    <td>{{ $f->inmueble->numero_catastral }}</td>
                    <td>{{ $f->mesYear }}</td>
                    <td>{{$f->fechaVecimiento->format("d/m/Y")}}</td>
                    <td class="text-right">${{number_format($f->pagoTotal,2)}}</td>
                    <td>
                      @if($f->fechaVecimiento < date("Y-m-d") && $f->estado==1)
                      <label for="" class="label-danger col-xs-12">Vencida</label>
                      @elseif($f->fechaVecimiento < date("Y-m-d") && $f->estado==3) 
                      <label for="" class="label-success col-xs-12">Pagado</label>
                      @elseif($f->fechaVecimiento >= date("Y-m-d") && $f->estado==1)
                      <label for="" class="label-primary col-xs-12">Pendiente</label>
                      @elseif($f->estado==3)
                      <label for="" class="label-success col-xs-12">Pagada</label>
                      @elseif($f->estado==3)
                      <label for="" class="label-danger col-xs-12">Anulada</label>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
                
              <div class="pull-right">

              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>
@endsection