<div class="form-group{{ $errors->has('empleado_id') ? ' has-error' : '' }}">
	<label for="" class="col-md-4 control-label">Empleado</label>
	<div class="col-md-6">
		<select name="empleado_id" id="empleado" class="form-control">
			<option value="">Seleccione</option>
		</select>
		
	</div>
	<div class="col-md-2">
		<button class="btn btn-default" type="button" id="" data-toggle="modal" data-target="#btnempleado"
		title="Nuevo empleado"><span class="glyphicon glyphicon-plus"></span></button>
	</div>
</div>

<div class="form-group{{ $errors->has('categoriatrabajo_id') ? ' has-error' : '' }}">
	<label for="" class="col-md-4 control-label">Categoría</label>
	<div class="col-md-4">
		<select name="categoriatrabajo_id" id="categoriatrabajo" class="form-control">
			<option value="">Seleccione</option>
		</select>
	</div>
	<div class="col-md-2">
		<button class="btn btn-default" type="button" id="" data-toggle="modal" data-target="#btncategoriatrabajo" title="Nueva categoría"><span class="glyphicon glyphicon-plus"></span></button>
	</div>
</div>

<div class="form-group{{ $errors->has('cargo_id') ? ' has-error' : '' }}">
	<label for="" class="col-md-4 control-label">Cargo</label>
	<div class="col-md-4">
		<select name="cargo_id" id="cargo" class="form-control">
			<option value="">Seleccione</option>
		</select>
	</div>
	<div class="col-md-2">
		<button class="btn btn-default" type="button" id="" data-toggle="modal" data-target="#btncargo" title="Nuevo cargo"><span class="glyphicon glyphicon-plus"></span></button>
	</div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="btnempleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Empleado
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    @include('empleados.formulario')
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarempleado" data-dismiss="modal" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="btncategoriatrabajo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Categoría trabajo
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    @include('categoriatrabajos.formulario')
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarcategoriatrabajo" data-dismiss="modal" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="btncargo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-heading">Registro de Cargo
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="panel-body">
                    @include('cargos.formulario')
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="guardarcargo" data-dismiss="modal" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>