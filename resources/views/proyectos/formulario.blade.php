<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
    <label for="nombre" class="col-md-4 control-label">Nombre</label>

    <div class="col-md-6">

        {!!Form::textarea('nombre',null,['class'=>'form-control','rows' => 2, 'id'=>'nombre','autofocus','autocomplete'=>'off'])!!}
    </div>
</div>

    <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
    <label for="monto" class="col-md-4 control-label">Monto total  ($)</label>

    <div class="col-md-4">
        {!!Form::number('monto',null,['class'=>'form-control','id'=>'monto','readonly','steps' => '0.00'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }}">
    <label for="motivo" class="col-md-4 control-label">Justificación</label>

    <div class="col-md-6">
        {!!Form::textarea('motivo',null,['class'=>'form-control','id'=>'motivo', 'rows'=>3,'autocomplete'=>'off'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
    <label for="direccion" class="col-md-4 control-label">Dirección donde se desarrollará</label>

    <div class="col-md-6">
        {!!Form::textarea('direccion',null,['class'=>'form-control','id'=>'direccion','autofocus','rows'=>3,'autocomplete'=>'off'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('fecha_inicio') ? ' has-error' : '' }}">
    <label for="fecha_inicio" class="col-md-4 control-label">Periodo del proyecto</label>

    <div class="col-md-3">
        <label for="fecha_inicio" class="control-label">Fecha de inicio</label>
        {!!Form::text('fecha_inicio',null,['class'=>'fecha form-control','id'=>'fecha_inicio','autocomplete'=>'off'])!!}
    </div>
    <div class="col-md-3">
        <label for="fecha_fin" class="control-label">Fecha de finalización</label>
        {!!Form::text('fecha_fin',null,['class'=>'fecha form-control','id'=>'fecha_fin','autocomplete'=>'off'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('plazo') ? ' has-error' : '' }}">
    <label for="plazo" class="col-md-4 control-label">Plazo de ejecución</label>

    <div class="col-md-4">
        {!!Form::number('plazo',null,['class'=>'form-control','id'=>'plazo','readonly'])!!}
    </div>
</div>

<div class="form-group">
    <center><label for="" class="col-md-12">Fondos del Proyecto</label></center>
</div>

<div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
    <label for="" class="col-md-4 control-label">Fuente de financiamiento</label>

        <div class="col-md-6">
            <select class="form-control chosen-select-width" id="cat_id">
            <option value="">Seleccione una fuente</option>
            </select>
        </div>
        
</div>

    <div class="form-group">
    <label for="" class="col-md-4 control-label">Ingrese el monto</label>
    <div class="col-md-6">
        <input type="number" id="cant_monto" class="form-control" step="0.00" min="0.00">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary" type="button" id="btnAgregarfondo">Agregar</button>
    </div>
</div>

<div class="form-group">
    <label for="fecha_fin" class="col-md-4 control-label"></label>

    <div class="col-md-6">
        <table class="table table-striped table-bordered" id="tbFondos">
            <thead>
            <tr>
                <th>Fuente</th>
                <th>Cantidad</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody id="cuerpo_fondos"></tbody>
            <tfoot id="pie_monto">
                <tr>
                    <td class="text-left" colspan="1"><b>Total $</b></td>
                    <td colspan="2" style="text-align:left;" id="totalEnd">0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{--                         <div class="form-group">
    <label for="" class="col-md-6">¿El proyecto cuenta con una organización colaboradora?</label>
    <input type="checkbox" id="colaboradora">
</div> --}}

<div class="form-group" >
    <center id="cola"></center>
</div>

<div class="form-group{{ $errors->has('monto_desarrollo') ? ' has-error' : '' }}">
    <label for="desarrollo" class="col-md-4 control-label">Monto de Desarrollo  ($)</label>
    <div class="col-md-4">
        {!!Form::text('monto_desarrollo',null,['class'=>'form-control','id'=>'monto_desarrollo','autocomplete'=>'off'])!!}
    </div>
</div>

<div class="form-group{{ $errors->has('beneficiarios') ? ' has-error' : '' }}">
    <label for="beneficiarios" class="col-md-4 control-label">Beneficiarios</label>

    <div class="col-md-4">
        {!!Form::text('beneficiarios',null,['class'=>'form-control','id'=>'beneficiarios','autocomplete'=>'off'])!!}
    </div>
</div>