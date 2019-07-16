@extends('pdf.plantilla')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
@section('reporte')
<br>
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

  <p style="font-size:14">Reunidos en: .......................................................................................; a las: ...........................</p>
  <p style="font-size:14">................. del día: ......................................................................................................................<p>
      <p style="font-size:14"> Los señores: <b>{{$orden->cotizacion->proveedor->nombre}}</b> Ofertante y <b>{{$configuracion->nombre_alcalde}}</b> Alcalde municipal</p>
      <p style="font-size:14">A efecto de constatar que lo que a continuación se detalla, se entrega y recibe de acuerdo a lo establecido en la Orden de Compra correspondiente;</p>
@endsection
