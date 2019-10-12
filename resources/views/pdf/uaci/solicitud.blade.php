@extends('pdf.plantilla')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
@section('reporte')
  <div id="content">
    <br>



    <table width="100%" border="1px">
      <td>

      La Alcaldía Municipal de Verapaz, a través de la Unidad de Adquisiciones y Contrataciones Institucional UACI, somete a competencia de personas naturales y jurídicas {{$solicitud->tipo==1 ? 'el proyecto: '. $solicitud->proyecto->nombre : 'la actividad: '. $solicitud->requisicion->actividad}}
      <p>Según detalle:</p>

      </td>
    </table>
    <br>
    <table class="table table-bordered" width="100%" rules=>
      <thead>
        <tr>
          <th>Item</th>
          <th>Descripción</th>
          <th>Unidad de medida</th>
          <th>Cantidad</th>
          <th>Precio unitario</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @if($tipo==1)
        @foreach($solicitud->detalle as $detalle)
        <tr>
          <td>{{$indice+1}}</td>
          <td>{{$detalle->material->nombre}}</td>
          <td>{{$detalle->material->unidadmedida->nombre_medida}}</td>
          <td>{{$detalle->cantidad}}</td>
          <td></td>
          <td></td>
        </tr>
        @endforeach
      @else
        @foreach($solicitud->detalle as $indice => $detalle)
        <tr>
          <td>{{$indice+1}}</td>
          <td>{{$detalle->material->nombre}}</td>
          <td>{{$detalle->material->unidadmedida->nombre_medida}}</td>
          <td>{{$detalle->cantidad}}</td>
          <td></td>
          <td></td>
        </tr>
        @endforeach
        @endif
      </tbody>
    </table>

    <table>
      <td>
      Condiciones de Compra:
      <p></p>
      1. Enviar cotización a nombre de Alcaldía Municipal de Verapaz, depto. de San Vicente, debidamente sellada y firmada por Representante Legal o Ejecutivo de Ventas, con atención a <b>{{$solicitud->encargado}}</b>, {{$solicitud->cargo_encargado}} a más tardar el día <b>{{$solicitud->fecha_limite->format('l d, F Y')}}</b>, en oficinas de la Alcaldía Municipal de Verapaz en la dirección física o la dirección electrónica descrita al pie de ésta página.
      <p></p>
      2. Los precios deben ser en US$, con IVA incluido.
      <p></p>
      3. Periodo de vigencia de la oferta de __ dias.
      <p></p>
      4. La forma de pago para este suministro es: <b>{{$solicitud->formapago->nombre}}.</b>
      <p></p>
      5. Adjuntar fotocopia de NIT y NRC de la Empresa o Persona natural, si es contribuyente; caso contrario anexar fotocopia de DUI.
      <p></p>
      6. Los productos deben ser de excelente calidad y durabilidad.
      <p></p>
      7. Tiempo de entrega, 1 día hábil después de emitida la Orden de Compra.
      <p></p>
      8. Lugar de entrega del suministro es {{ $solicitud->tipo==1 ?$solicitud->proyecto->direccion : "Calle Pbro Norberto Marroquin y 1° av sur, barrio Mercedes, Verapaz, San Vicente"}} y los costos de entrega del suministro corren por cuenta del suministrante.
      <p></p>
      9. La municipalidad se reserva el derecho de adjudicar el bien o servicio objeto de esta invitación cuya oferta económica no sea necesariamente la de menor precio, ya que se tomará en cuenta la oferta que más convenga a los intereses institucionales.
      <p></p>
      10. FAVOR LLENAR ANEXO DE IDENTIFICACION DE OFERTANTE.
      </td>
    </table>
  </div>
@endsection
