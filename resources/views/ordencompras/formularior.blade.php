<div class="form-group{{ $errors->has('proyecto') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Nombre de la actividad</label>

    <div class="col-md-6">
      {{Form::hidden('cotizacion_id',$requisicion->solicitudcotizacion->cotizacion_seleccionada->id,['id'=>'cotizacion_id'])}}
        {!!Form::textarea('actividad',$requisicion->actividad,['rows'=>3,'class' => 'form-control','placeholder' => 'Digite la actividad','readonly'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('proveedor') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Nombre del proveedor</label>

    <div class="col-md-6">
      {{Form::text('',$requisicion->solicitudcotizacion->cotizacion_seleccionada->proveedor->nombre,['class'=>'form-control','readonly'])}}
    </div>
</div>


<div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Condiciones de pago</label>

    <div class="col-md-6">
      {{Form::text('',$requisicion->solicitudcotizacion->cotizacion_seleccionada->formapago->nombre,['class'=>'form-control','readonly'])}}
    </div>
</div>

<div class="form-group{{ $errors->has('adminorden') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Nombre del administrador de la orden</label>
    <div class="col-md-6">
        {!!Form::text('adminorden',$cotizacion->solicitudcotizacion->requisicion->user->empleado->nombre,['class'=>'form-control','id'=>'adminorden','readonly'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Dirección de entrega</label>

    <div class="col-md-6">
        {!!Form::textarea('direccion_entrega',null,['rows' => 3,'class'=>'form-control','id'=>'direccion_entrega','placeholder'=>'Digite la direccion de entrega de los materiales'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Periodo de entrega</label>

    <div class="col-md-2">
        {!!Form::text('fecha_inicio',null,['class'=>'form-control','id'=>'fecha_inicio','placeholder'=>'Fecha de inicio','autocomplete'=>'off'])!!}
    </div>
    <div class="col-md-1"><label for="">al</label></div>
    <div class="col-md-2">
        {!!Form::text('fecha_fin',null,['class'=>'form-control','id'=>'fecha_fin','placeholder'=>'Fecha de finalizacion','autocomplete'=>'off'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Observaciones</label>

    <div class="col-md-6">
        {!!Form::textarea('observaciones',null,['id'=>'observaciones','rows'=>2,'class'=>'form-control','placeholder'=>'Digite las observaciones (si las hay)'])!!}
    </div>
</div>

<div class="box-body table-responsive">
    <table class="table table-striped table-bordered table-hover" id="">
        <thead>
            <tr>
                <th width="5%">N°</th>
                <th width="40%">Descripcion</th>
                <th width="10%">Marca</th>
                <th width="10%">Unidad de medida</th>
                <th width="10%">Cantidad</th>
                <th width="10%">Precio Unitario</th>
                <th width="15%">Subtotal</th>
            </tr>
            <?php $total=0.0; ?>
        </thead>
        <tbody id="cuerpo">
          @foreach($cotizacion->detallecotizacion as $key => $detalle)
            <?php $total=$total+$detalle->precio_unitario*$detalle->cantidad;?>
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$detalle->descripcion}}</td>
              <td>{{$detalle->marca}}</td>
              <td>{{$detalle->unidadmedida->nombre_medida}}</td>
              <td>{{$detalle->cantidad}}</td>
              <td>${{number_format($detalle->precio_unitario,2)}}</td>
              <td>${{number_format($detalle->precio_unitario*$detalle->cantidad,2)}}</td>
            </tr>
          @endforeach
        </tbody>
        <tfoot id="pie">
            <tr>
              <th colspan="6">Total en letras: {{numaletras($total)}} </th>
              <th>${{number_format($total,2)}}</th>
            </tr>
        </tfoot>
    </table>
</div>
