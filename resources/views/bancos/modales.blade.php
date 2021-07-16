<div class="modal fade" id="modal_registrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-sm">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar Nuevo</h4>
			</div>
			<div class="modal-body">
				<form id="form_banco">
					<div class="form-group">
						<label for="">
							Nombre banco
						</label>
						<input type="text" name="nombre" autocomplete="off" class="form-control">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<center>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				<button id="btnguardar" type="button" class="btn btn-success">Guardar</button></center>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labeledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-sm">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Editar</h4>
			</div>
			<div class="modal-body">
				<form id="form_edit">
					<div class="form_group">
						<label for="">Nombre Banco
						</label>
						<input type="text" name="nombre" id="e_nombre" class="form-control">
						<input type="hidden" name="id" id="elid">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<center>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
				<button id="btneditar" type="button" class="btn btn-success">Guardar</button></center>
			</div>
		</div>
	</div>
</div>