@extends('pdf.catastro.plantilla')
@section('reporte')
  @foreach($ids as $key => $mid)
@php
$factura= App\Factura::find($mid);
      $items=$factura->items;
      $total=$items->sum('precio_servicio');
      $fiesta=($factura->porcentajeFiestas/100)*$total;
      $sumat=$total+$fiesta+$factura->mora;
      $array_meses=['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
@endphp
<style>
  .table-simple th,.table-simple td{
  border: 1px white solid;
}
</style>
<div id="content">
  <table class="table-simple" width="100%" rules=all>
    <tbody>
      <tr>
        <td style="width: 20%"></td>
        <td colspan="4" style="width: 20%">Verapaz</td>
        <td>{{date('d')}}</td>
        <td>{{$array_meses[intval(date('m')-1)]}}</td>
        <td style="text-align: right">{{date('Y')}}</td>
      </tr>
      <tr>
        <td></td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="width: 20%"></td>
        <td colspan="2" style="width: 20%">{{number_format($sumat,2,'.', ',')}}</td>
        <td colspan="2" style="width: 22%" style="color:white"></td>
        <td colspan="3" style="color:white">Cargo en caja, rubros o cuentas</td>
      </tr>
    <tr>
      <td></td>
      <td colspan="4"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
      <tr>
        <td colspan="3"></td>
        <td colspan="2" style="color:white">mandamiento de ingreso</td>
        <td style="color:white">Fondo municipal</td>
        <td style="color:white">Especif. municpal</td>
        <td style="color:white">Especif. fiscales</td>
      </tr>
      @foreach ($items as $i => $item)
      <tr>
        <td colspan="3">
          @if(($i+1)==1)
          {{$factura->inmueble->contribuyente->nombre}}
          @endif
          @if(($i+1)==5)
         
          {{App\Factura::convertir((int)$sumat)}} y {{number_format($sumat-((int)$sumat),2,'.','.')*100}}/100 US DOLARES
          @endif
          @if(($i+1)==9)
         
          {{App\Factura::personal('tesoreria')}}
          @endif
          @if(($i+1)==12)
          
          {{App\Factura::personal('contabilidad')}}
          @endif
          @if(($i+1)==13)
          ----
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
      @if($factura->mora>0)
      <tr>
        <td colspan="3"></td>
        <td colspan="2">Mora e intereses</td>
        <td>{{number_format($factura->mora,2)}}</td>
        <td></td>
        <td></td>
      </tr>
      @endif
      @php
          $bandera=true;
      @endphp
      @for($a=$items->count();$a<12;$a++)
      <tr>
        <td colspan="3">           
            @if(($a+1)==1)
            {{$factura->inmueble->contribuyente->nombre}}
            @endif
            @if(($a+1)==6)
            {{App\Factura::convertir((int)$sumat)}} y {{number_format($sumat-((int)$sumat),2,'.','.')*100}}/100 US DOLARES
            @endif
            @if(($a+1)==9)
            {{App\Factura::personal('tesoreria')}}
            @endif
            @if(($a+1)==8)
            Factura correspodiente a: {{$factura->mesYear}}
            @endif
            @if(($a+1)==12)
            {{App\Factura::personal('contabilidad')}}
            @endif
          </td>
        @if($bandera)
        
        <td colspan="2">
        Fiestas patronales ({{$factura->porcentajeFiestas}}%)
        </td>
        <td>{{number_format($fiesta,2,'.', ',')}} </td>
        @else
        <td colspan="2" style="color:white">{{$a+1}}
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
        <td colspan="2" style="color:white">Totales</td>
        <td>{{number_format($sumat,2,'.', ',')}}</td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>
  @if($key<(count($ids)-1))
  <div style="page-break-after:always;"></div>
  @endif
  @endforeach
@endsection
