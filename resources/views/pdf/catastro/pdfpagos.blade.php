@extends('pdf.plantilla')
@section('reporte')
  @foreach($facturas as $key => $factura)
@php
      $items=$factura->items;
      $total=$items->sum('precio_servicio');
      $fiesta=($factura->porcentajeFiestas/100)*$total;
      $sumat=$total+$fiesta;
@endphp
  <div id="content">
    <table width="100%" rules=all>
      <tbody>
        <tr>
          <td style="width: 20%"></td>
          <td colspan="2" style="width: 20%">{{number_format($sumat,2,'.', ',')}}</td>
          <td colspan="2" style="width: 20%">Concepto ppp</td>
          <td colspan="3">Cargo en caja, rubros o cuentas</td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <td colspan="2">mandamiento de ingreso</td>
          <td>Fondo municipal</td>
          <td>Especif. municpal</td>
          <td>Especif. fiscales</td>
        </tr>
        @foreach ($items as $i => $item)
        <tr>
          <td colspan="3">
            @if(($i+1)==1)
            Nombre
            @endif
            @if(($i+1)==5)
            Cantidad
            @endif
            @if(($i+1)==9)
            Tesorero municipal
            @endif
            @if(($i+1)==12)
            Contabilidad
            @endif
          </td>
          <td colspan="2">
            {{$item->servicio($item->tipoinmueble_id)}}
          </td>
          <td>{{number_format($item->precio_servicio,2,'.', ',')}}</td>
          <td></td>
          <td></td>
        </tr>
        @endforeach
        @php
            $bandera=true;
        @endphp
        @for($a=$items->count();$a<12;$a++)
        <tr>
          <td colspan="3">           
              @if(($a+1)==1)
              Nombre x
              @endif
              @if(($a+1)==5)
              Cantidad x
              @endif
              @if(($a+1)==9)
              Tesorero municipal x
              @endif
              @if(($a+1)==12)
              Contabilidad x
              @endif</td>
          @if($bandera)
          <td colspan="2">
          Fiestas ({{$factura->porcentajeFiestas}}%)
          </td>
          <td>{{number_format($fiesta,2,'.', ',')}}</td>
          @else
          <td colspan="2">{{$a+1}}
          </td>
          <td></td>
          @endif
          <td></td>
          <td></td>
        </tr>
        @php
            $bandera=false;
        @endphp
        @endfor
        <tr>
          <td colspan="3"></td>
          <td colspan="2">Totales</td>
          <td>{{number_format($sumat,2,'.', ',')}}</td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
  @if($key<($facturas->count()))
  <div style="page-break-after:always;"></div>
  @endif
  @endforeach
@endsection
