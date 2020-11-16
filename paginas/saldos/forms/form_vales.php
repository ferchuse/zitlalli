<form class="was-validated " id="form_vales">
	<!-- The Modal -->
	<div class="modal fade" id="modal_vales">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title text-center">Vale de Operador</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
                    <div class="form-group">
                        <label for="">Concepto:</label>
                        <input class="form-control" id="concepto" name="concepto" required>
					</div>
					
                    <div class="form-group">
                        <label for="">Importe:</label>
                        <input class="form-control" id="importe" name="importe" step="any" required>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
				</div>
				
			</div>
		</div>
	</div>
</form>