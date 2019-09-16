@extends('pdf.plantilla') @include('pdf.uaci.cabecera') @section('titulo')
{{ $tipo }}
@endsection @section('reporte')
<div id="content">
  <br /><br />
  
 
  <br />
  <table width="100%" rules="">
    <tbody>
      <tr>
        <td>
          <p>
            <b>UNIDAD SOLICITANTE:</b> {{$requisicion->unidad->nombre_unidad}}
          </p>
          <b>RESPONSABLE:</b> {{$requisicion->user->empleado->nombre}}
        </td>
        <td>
          <p><b>FECHA:</b> {{ fechaCastellano($requisicion->created_at) }}</p>
          <b>FIRMA:</b> ___________________________
        </td>
      </tr>
    </tbody>
  </table>
  <br /><br />
  <p></p>
  <table width="100%" border="1" class="table" rules="all">
    <thead>
      <tr style="background-color:#BCE4F3;">
        <th width="5%">N° ITEM</th>
        <th width="8%">CANTIDAD SOLICITADA</th>
        <th width="50%%"><center>DESCRIPCIÓN</center></th>
        <th width="15%">U/MEDIDA</th>
        @php $correlativo = 0; $total = 0.0; @endphp
      </tr>
    </thead>
    <tbody>
      @foreach($requisicion->requisiciondetalle as $index => $detalle)
      <tr>
        <td>
          {{ $index + 1 }}
        </td>
        <td>
          {{$detalle->cantidad}}
        </td>
        <td>
          {{$detalle->material->nombre}}
        </td>
        <td>
          {{$detalle->unidadmedida->nombre_medida}}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <p></p>
  OBSERVACIONES: {{$requisicion->observaciones}}

  <p></p>

  <table width="100%" cellspacing="30px">
    <tr>
      <td>
        AUTORIZA:
      </td>
      <td>
        RECIBE:
      </td>
    </tr>
    <tr>
      <td>
        F.____________________<br />
        <p></p>
        ALCALDE MUNICIPAL
      </td>
      <td>
        F.____________________<br />
        <p></p>
        JEFE DE UACI
      </td>
    </tr>
  </table>
</div>
@endsection @include('pdf.uaci.pie')
