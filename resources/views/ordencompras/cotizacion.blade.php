<div class="box-body table-responsive">
    <table class="table table-striped table-bordered table-hover" id="">
        <thead>
            <tr>
                <th width="5%">N°</th>
                <th width="40%">Descripcion</th>
                <th width="10%">Marca</th>
                <th width="10%">Unidad de medida</th>
                <th width="10%">Cantidad</th>
                <th width="10%">Precio unitario
                <th width="15%">Subtotal</th>
            </tr>
            @php
              $total=0.0;
              $correlativo=0;
            @endphp
        </thead>
        <tbody id="cuerpo">
          @foreach($cotizacion->detallecotizacion as $key => $detalle)
            @php
              $total=$total+($detalle->cantidad*$detalle->precio_unitario)
            @endphp
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$detalle->descripcion}}</td>
              <td>{{$detalle->marca}}</td>
              <td>{{$detalle->unidad_medida}}</td>
              <td>{{$detalle->cantidad}}</td>
              <td>${{number_format($detalle->precio_unitario,2)}}</td>
              <td>${{number_format($detalle->cantidad*$detalle->precio_unitario,2)}}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot id="pie">
            <tr>
              <th colspan="2">Total en letras: </th>
              <th id="letras" colspan="4">{{numaletras($total)}}</th>
              <th id="total">${{number_format($total,2)}}</th>
            </tr>
        </tfoot>
    </table>
</div>
