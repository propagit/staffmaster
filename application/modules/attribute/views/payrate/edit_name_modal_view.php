<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Edit Pay Rate Name</h4>
		</div>
		<div class="col-md-12">			
			<div class="modal-body modal-form">
				<form class="form-horizontal" id="form_edit_payrate_name" role="form">
				<input type="hidden" name="payrate_id" value="<?=$payrate['payrate_id'];?>" />
					<div class="row">
						<div class="form-group">
							<label class="col-md-3 control-label">Pay Rate Name:</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="name" value="<?=$payrate['name'];?>" />
							</div>
						</div>
					</div>
					
					<div id="field-submit" class="row">
						<div class="form-group">
							<div class="col-lg-3 col-lg-offset-3">
								<button type="button" class="btn btn-core" id="btn-update-payrate-name"><i class="fa fa-save"></i> Update All</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#btn-update-payrate-name').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax_payrate/update_name",
			data: $('#form_edit_payrate_name').serialize(),
			success: function(html) {
				load_nav_payrates(<?=$payrate['payrate_id'];?>);
				$('.bs-modal-lg').modal('hide');
			}
		})
	})
})
</script>