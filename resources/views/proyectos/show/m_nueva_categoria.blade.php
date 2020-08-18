@php
	$unidades=[];
	$unidades=\App\UnidadMedida::get();
@endphp
<div class="modal fade" tabindex="-1" id="nueva_categoria" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Registrar por categoría</h4>
      </div>
      <div class="modal-body">
				<input type="hidden" id="id-proy" value="{{$proyecto->id}}">
      	<div class="form-group col-md-12">
					<label for="" class="col-md-2">Categoria</label>
					<div class="col-md-8" id="select">
							<select name="item" id="item" required class="chosen-select-width">
							</select>
					</div>
					<div class="col-md-2">
							<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalcategoria"><span class="glyphicon glyphicon-plus"></span></button>
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="" class="col-md-2">Descripción</label>
					<div class="col-md-8" id="select">
							<select name="descripcion_item" id="descripcion_item" required class="chosen-select-width">
								<option value="">Seleccione un item primero</option>
							</select>
					</div>
				</div>
				<div class="form-group col-md-12">
					<label for="" class="col-md-2">Unidad de medida</label>
					<div class="col-md-8" id="select">
							<select name="unidad_medida" id="unidad_medida" required class="chosen-select-width">
								<option value="">Seleccione una unidad</option>
								@foreach ($unidades as $u)
									<option value="{{$u->id}}">{{$u->nombre_medida}}</option>
								@endforeach
							</select>
					</div>
				</div>
				<div class="form-group col-md-5">
					<label for="" class="col-md-6">Cantidad</label>
					<div class="col-md-6" style="padding:0">
						<input type="number" name="cantidad" id="cantidad" class="form-control" min="0.1" step="0.1" value="1">
					</div>
				</div>
				<div class="form-group col-md-5">
					<label for="" class="col-md-6">Precio ($)</label>
					<div class="col-md-6" style="padding:0">
						<input type="number" name="precio" id="precio" class="form-control" min="0.1" step="0.1" value="1">
					</div>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-success" disabled id="add_catalogo">Agregar</button>
				</div>
			</div>
			<div class="clearfix"></div>
			<hr>
			<div class="clearfix"></div>
			<center>
				<h4>Detalle</h4>
			</center>
			<div class="col-md-12">
				<table class="table table-hover" id="tabla_detalle">
					<thead>
						<th>Descripción</th>
						<th width="15%">Unidad de medida</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Subtotal</th>
						<th>Opciones</th>
					</thead>
					<tbody id="cuerpito"></tbody>
				</table>
			</div>
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<span class="label label-success col-md-12" style="font-size: 90%" id="total">
					$ 0.00
				</span>
			</div>
			<div class="clearfix"></div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		@if($proyecto->presupuesto!="")
		<button type="button" id="edit" class="btn btn-primary">Registrar</button>
		@else
		<button type="button" id="sav" class="btn btn-primary">Registrar</button>
		@endif
      </div>
    </div>
  </div>
</div>