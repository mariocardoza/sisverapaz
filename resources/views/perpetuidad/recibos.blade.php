@extends('layouts.app')

@section('migasdepan')
<h1>
    Recibos de titulos a perpetuidad
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/ingresos') }}"><i class="fa fa-home"></i> Ingresos</a></li>
        <li class="active">Recibos de titulos a perpetuidad</li>
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
            <div class="btn-group">
                <a href="{{url('ingresos')}}" class="btn btn-primary">Impuestos municipales</a>
                <button class="btn btn-primary">Partidas</button>
              <a href="{{url('construcciones/recibos')}}" class="btn btn-primary">Construcciones <span class="label label-danger">{{\App\Construccion::whereEstado(3)->count()}}</span></a>
              <a href="{{url('perpetuidad/recibos')}}" class="btn btn-primary">Titulos a perpetuidad <span class="label label-danger">{{\App\Perpetuidad::whereEstado(1)->count()}}</span></a>
              <button class="btn btn-primary">Otros</button>
            </div>
            <br><br>
            <table class="table table-striped table-bordered table-hover" id="example2">
              <thead>
                <th>N°</th>
                <th>Contribuyente</th>
                <th>Detalle</th>
                <th>Monto</th>
                <th>Fiestas</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acción</th>
              </thead>
              <tbody>
                @foreach ($recibos as $i=> $r)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$r->contribuyente->nombre}}</td>
                        <td>Cobro por derecho de nicho</td>
                        <td>${{number_format($r->costo,2)}}</td>
                        <td>${{number_format($r->costo*($r->fiestas/100),2)}}</td>
                        <td>${{number_format($r->costo+($r->costo*($r->fiestas/100)),2)}}</td>
                        <td>
                            @if($r->estado==1)
                            <label for="" class="label-primary col-sm-12">Recibo emitido</label>
                            @else
                            <label for="" class="label-success col-sm-12">Pagado</label>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-success vista_previa" href="{{url ('reportestesoreria/recibop/'.$r->id)}}" target="_blank"><i class="fa fa-print"></i></a>
                            <button class="btn btn-primary"><i class="fa fa-money"></i></button>
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