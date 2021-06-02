@extends('layouts.app')

@section('migasdepan')
<h1>
        Listado de recibos para el negocio: {{ $negocio->nombre }}
        <br>
        Cuenta N°: {{ $negocio->contribuyente->numero_cuenta }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{{ url('contribuyentes') }}"><i class="fa fa-home"></i> Contribuyentes</a></li>
        <li><a href="{{ url('contribuyentes/'.$negocio->contribuyente->id) }}"><i class="fa fa-home"></i> Contribuyente {{ $negocio->contribuyente->nombre }}</a></li>
        <li class="active">Listado de contribuyentes</li>
      </ol>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-heading">

            </div>
            <div class="box-body">
                <table class="table" id="example2">
                    <thead>
                        <th>N°</th>
                        <th>Mes/año</th>
                        <th>Fecha de vencimiento</th>
                        <th>Referencia</th>
                        <th>Pago total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($negocio->factura  as $i => $f)
                        <tr>
                            <td>{{$i+1}}</td>
                            <td>{{$f->mesYear}}</td>
                            <td>{{$f->fechaVencimiento->format('d/m/Y')}}</td>
                            <td>{{$f->codigo}}</td>
                            <td>${{$f->pagoTotal}}</td>
                            <td>
                                @if($f->estado==1 && $f->fechaVencimiento < date('Y-m-d'))
                                Vencida
                                @elseif($f->estado ==1 && $f->fechaVencimiento > date('Y-m-d'))
                                Pendiente
                                @else
                                Cancelada
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a target="_blank" href="{{url('verfacturaspendientesn?cbid='.$f->id)}}" class="btn btn-primary"><i class="fa fa-print"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection