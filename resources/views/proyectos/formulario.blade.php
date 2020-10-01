<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
            <label for="nombre" class="control-label">Nombre</label>
            <div class="">
                {!!Form::textarea('nombre',null,['class'=>'form-control','rows' => 2, 'id'=>'nombre','autofocus','autocomplete'=>'off'])!!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
            <label for="direccion" class="control-label">Dirección donde se desarrollará</label>
            <div class="">
                {!!Form::textarea('direccion',null,['class'=>'form-control','id'=>'direccion','autofocus','rows'=>3,'autocomplete'=>'off'])!!}
            </div>
        </div>

        <div class="form-group">
            <div class="">
                <label for="fecha_inicio" class="control-label">Fecha de inicio</label>
                {!!Form::text('fecha_inicio',null,['class'=>'fecha form-control','id'=>'fecha_inicio','autocomplete'=>'off'])!!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
            <label for="" class="control-label">Fuente de financiamiento</label>
                <div class="">
                    <select class="form-control chosen-select-width" id="cat_id">
                    <option value="">Seleccione una fuente</option>
                    </select>
                </div> 
        </div>

        <div class="form-group">
            <label for="" class="control-label">Ingrese el monto</label>
            <div class="">
                <input type="number" id="cant_monto" class="form-control" step="0.00" min="0.00">
            </div>
            <div class="">
                <button class="btn btn-primary" type="button" id="btnAgregarfondo">Agregar</button>
            </div>
        </div>

        <div class="form-group">
            <label for="fecha_fin" class="control-label"></label>
        
            <div class="">
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

       
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }}">
            <label for="motivo" class="control-label">Justificación</label>
            <div class="">
                {!!Form::textarea('motivo',null,['class'=>'form-control','id'=>'motivo', 'rows'=>3,'autocomplete'=>'off'])!!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('beneficiarios') ? ' has-error' : '' }}">
            <label for="beneficiarios" class="control-label">Beneficiarios</label>
            <div class="">
                {!!Form::textarea('beneficiarios',null,['class'=>'form-control','rows'=>2,'id'=>'beneficiarios','autocomplete'=>'off'])!!}
            </div>
        </div>

        <div class="form-group">
            <div class="">
                <label for="fecha_fin" class="control-label">Fecha de finalización</label>
                {!!Form::text('fecha_fin',null,['class'=>'fecha form-control','id'=>'fecha_fin','autocomplete'=>'off'])!!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
            <label for="monto" class="control-label">Monto total  ($)</label>
            <div class="">
                {!!Form::number('monto',null,['class'=>'form-control','id'=>'monto','readonly','steps' => '0.00'])!!}
            </div>
        </div>

        <div class="form-group{{ $errors->has('monto_desarrollo') ? ' has-error' : '' }}">
            <label for="desarrollo" class="control-label">Monto de Desarrollo  ($)</label>
            <div class="">
                {!!Form::text('monto_desarrollo',null,['class'=>'form-control','id'=>'monto_desarrollo','autocomplete'=>'off'])!!}
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-12">
                    <div id="mapita" style="height: 400px;"></div>
                </div>
            </div>
        </div>

        <input type="text" readonly id="lat" />
        <input type="text" readonly id="lng" />
    </div>
</div>
