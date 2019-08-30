@extends('pdf.plantilla')
@include('pdf.uaci.cabecera')
@section('reporte')
<br><br>
  <table width="100%" rules="">
    <tr>
      <td colspan="3" width="">
        <center>
          {{$tipo}}
      </center>
      </td>
    </tr>
    <tr>
      <td width="15%"></td>
      <td width="70%"><hr style="color:blue; border:solid;border-width:3px;"><hr style="color:red; border:solid;border-width:3px;"></td>
      <td width="15%"></td>
    </tr>
  </table>
<br>
  <p style="font-size:14">Reunidos en: Verapaz, departamento de San Vicente; a las: {{date('H:i')}}
  del día: {{date('d/m/Y')}}.<p>
      <p style="font-size:14"> Los señores: <b>{{$orden->cotizacion->proveedor->nombre}}</b> Ofertante y <b>{{$configuracion->nombre_alcalde}}</b> Alcalde municipal</p>
      <p style="font-size:14">A efecto de entregar y recibir los bienes y servicios descritos a continuación:</p>
      <p style="font-size:14">
      @foreach ($orden->cotizacion->solicitudcotizacion->detalle as $detalle)
          <b>{{$detalle->material->nombre}}</b>
          @if(!$loop->last), @endif
      @endforeach
      </p>
      <p style="font-size:14">Dándonos por satisfechos ambas partes. Y en fe de lo cual firmamos la presente.</p>
      <br>
      <p><b>Entrega:</b></p>
      <p>Firma  __________________________________</p>
      <p>Nombre __________________________________</p>
      <br><br>
      <p class="text-right"><b>Recibe:</b></p>
      <p class="text-right">Firma  __________________________________</p>
      <p class="text-right">Nombre __________________________________</p>
      <p class="text-right">Firma  __________________________________</p>
      <p class="text-right">Nombre __________________________________</p>
      <p class="text-right">Firma  __________________________________</p>
      <p class="text-right">Nombre __________________________________</p>
@endsection
