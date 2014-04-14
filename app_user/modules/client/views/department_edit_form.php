<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
			<h4 class="modal-title">Edit Department</h4>
		</div>
		<form class="form-horizontal" role="form" id="form_edit_client_department">
			<div class="col-md-12">
				<div class="modal-body">
					<input type="hidden" name="department_id" value="<?=$department['department_id'];?>" />
					<h4 class="modal-body-title">Department Name</h4>
					<div class="form-group">
						<label for="name" class="col-md-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="name" value="<?=$department['name'];?>" placeholder="Enter department name">
						</div>
					</div>
					<div class="form-group">
						<label for="add-button" class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-10">
							<button id="btn_update_department" type="button" class="btn btn-info"><i class="fa fa-save"></i> Update Department</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#btn_update_department').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>client/ajax/update_department",
			data: $('#form_edit_client_department').serialize(),
			success: function(html) {
				$('.bs-modal-lg').modal('hide');
				list_departments();
			}
		});		
	});	
});
</script>