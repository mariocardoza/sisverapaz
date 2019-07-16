@extends('pdf.plantilla')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
@section('reporte')
<br>
<h4 class="text-center">{{$tipo}}</h4>
<table class="table">
@foreach ($requisicion->solicitudcotizacion->cotizacion as $cotizacion)
    <thead>
        <tr style="background-color:#BCE4F3;">
            <th>Proveedor: {{$cotizacion->proveedor->nombre}}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Producto</th>
            <th>Unidad de medida</th>
            <th>Cantidad</th>
            <th>Precio</th>
        </tr>
        @foreach ($cotizacion->detallecotizacion as $detalle)
            <tr>
                <td>{{$detalle->descripcion}}</td>
                <td>{{$detalle->unidadmedida->nombre_medida}}</td>
                <td>{{$detalle->cantidad}}</td>
                <td>${{number_format($detalle->precio_unitario,2)}}</td>
            </tr>
        @endforeach
    </tbody>
@endforeach
</table>

@endsection