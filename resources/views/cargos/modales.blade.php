@php
	$categorias=App\CatCargo::where('estado',1)->get();
@endphp
<div class="modal fade" id="modal_registrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar nuevo</h4>
			</div>
			<div class="modal-body">
				<form id="form_cargo">
					<div class="form-group">
						<label for="">
							Cargo
						</label>
						<input type="text" name="cargo" autocomplete="off" class="form-control">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Categoría</label>
						<div>
							<select name="catcargo_id" id="" class="chosen-select-width">
								<option value="">Seleccione un cargo</option>
								@foreach ($categorias as $item)
									<option value="{{ $item->id }}">{{$item->nombre}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<center><button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				<button id="btnguardar" type="button" class="btn btn-success">Guardar</button></center>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labeledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar</h4>
			</div>
			<div class="modal-body">
				<form id="form_edit">
					<div class="form_group">
						<label for="">Cargo</label>
						<input type="text" name="cargo" id="e_cargo" class="form-control">
						<input type="hidden" name="id" id="elid">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Categoría</label>
						<div>
							<select name="catcargo_id" id="catcargo_edit" class="chosen-select-width">
								<option value="">Seleccione un cargo</option>
								@foreach ($categorias as $item)
									<option value="{{ $item->id }}">{{$item->nombre}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<center><button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				<button id="btneditar" type="button" class="btn btn-success">Editar</button></center>
			</div>
		</div>
	</div>
</div>