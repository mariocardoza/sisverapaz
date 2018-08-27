@extends('pdf.plantilla')
@section('reporte')
@include('pdf.uaci.cabecera')
@include('pdf.uaci.pie')
  <div class="container">
      <div class="row">
          <div class="col-md-11">
              <div class="panel panel-primary">
                  <div class="panel-body">
                      <table width="100%" border="" rules="all">
                        <colgroup></colgroup>
                        <colgroup></colgroup>
                        <tbody>

                          <tr>
                            <td>SEÑORES: <b>{{$ordencompra->cotizacion->proveedor->nombre}}</b>
                              <p></p> NIT N°: <b>{{$ordencompra->cotizacion->proveedor->nit}}</b>
                              <p></p> DUI N°: <b>{{$ordencompra->cotizacion->proveedor->dui}}</b>
                              <p></p> TELÉFONO: <b>{{$ordencompra->cotizacion->proveedor->telefono}}</b>
                            </td>
                            <td>ORDEN N°: <b>{{$ordencompra->numero_orden}}</b>
                              <p></p> Solicitud N°: <b>{{$ordencompra->cotizacion->solicitudcotizacion->id}}</b>
                              <p></p> FECHA DE EMISIÓN: <b>{{$ordencompra->created_at->format('d-m-Y')}}</b>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                      <p></p>
                      Solicito a ustedes por favor entregar a la mayor brevedad posible y en días hábiles, después de haber recibido la Orden de Compra.
                      <br>
                      <!--div class="table-responsive"-->
                        <table width="100%" border="1" rules="all">
                          <thead>
                            <tr>
                              <th width="5%">N°</th>
                              <th width="50%">DESCRIPCIÓN</th>
                              <th width="15%">U/ DE MEDIDA</th>
                              <th width="10%">CANT.</th>
                              <th width="10%">P/ UNIT.</th>
                              <th width="17%">SUBTOTAL</th>
                              @php
                                $correlativo=0;
                                $total=0.0;
                              @endphp
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($ordencompra->cotizacion->detallecotizacion as $detalle)
                              <tr>
                                @php
                                  $correlativo++;
                                  $total=$total+$detalle->precio_unitario*$detalle->cantidad;
                                @endphp
                                <td><center>{{$correlativo}}</center></td>

                                <td>{{$detalle->descripcion}}</td>
                                <td><center>{{$detalle->unidad_medida}}</center> </td>
                                <td><center>{{$detalle->cantidad}}</center></td>
                                <td><p align="left">${{number_format($detalle->precio_unitario,2)}}</p> </td>
                                <td><p align="left">${{number_format($detalle->precio_unitario*$detalle->cantidad,2)}}</p> </td>
                              </tr>
                            @endforeach
                          </tbody>
                          <tfoot>
                            <!--<tr>

                              <td colspan="5"><center> Total en letras: <b>{{numaletras($total)}}</b></center></td>
                              <th><p align="left">${{number_format($total,2)}}</p></th>
                            </tr>-->

                            <tr>
                              <td colspan="5"> <b>SUB TOTAL</b></td>
                              <th><p align="left">${{number_format($total,2)}}</p></th>
                            </tr>

                            <tr>
                              <td colspan="5"> <b>(-) RETENCIÓN RENTA 10% </b></td>
                              <th><p align="left">$</p></th>
                            </tr>

                            <tr>
                              <td colspan="5"> <b>LÍQUIDO A RECIBIR: </b></td>
                              <th><p align="left">$</p></th>
                            </tr>

                          </tfoot>
                        </table>
                      <!--</div>-->
                      <p></p>
                      NOTA: FAVOR EMITIR FACTURA DE CONSUMIDOR FINAL O RECIBO A NOMBRE DE LA TESORERÍA MUNICIPAL DE VERAPAZ
                      <br>

                      <table width="100%" border="" rules="all">
                        <tbody>

                          
                          
                          <tr>
                            <th>LUGAR DE ENTREGA DE LOS SERVICIOS O PRODUCTOS</th>
                            <td>{{$ordencompra->direccion_entrega}}</td>
                          </tr>
                          <tr>
                            <th>CONDICIONES DE PAGO</th>
                            <td>{{$ordencompra->cotizacion->presupuestosolicitud->solicitudcotizacion->formapago->nombre}}</td>
                          </tr>
                          <tr>
                            <th width="40%">FUENTE DE FINANCIAMIENTO</th>
                            <td width="60%">
                              @foreach($ordencompra->cotizacion->presupuestosolicitud->presupuesto->proyecto->fondo as $fondos)
                                {{$fondos->fondocat->categoria}} / Contrapartida Municipal para
                              @endforeach
                              {{$ordencompra->cotizacion->presupuestosolicitud->presupuesto->proyecto->nombre}}
                            </td>
                          </tr>
                          <tr>
                            <th>FECHA DE ENTREGA DE LOS PRODUCTOS O SERVICIOS</th>
                            <td>
                              @if($ordencompra->fecha_fin == "")
                              {{$orden->fecha_inicio->format('d-m-Y')}}
                            @else
                              Desde {{$ordencompra->fecha_inicio->format('l d')}} de {{$ordencompra->fecha_inicio->format('F')}} del {{$ordencompra->fecha_inicio->format('Y')}} al {{$ordencompra->fecha_fin->format('l d')}} de {{$ordencompra->fecha_fin->format('F')}} del {{$ordencompra->fecha_fin->format('Y')}}
                            @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <table width="100%" border="" rules="all">
                        <tbody>
                          <tr>
                            <td>Autoriza:
                              <p>ALCALDE MUNICIPAL</p>
                            </td>
                            <td>Elaboró Orden de Compra:
                              <p>JEFE UACI</p>
                            </td>
                            <td>Es conforme:
                              <p>SUMINISTRANTE</p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
@endsection