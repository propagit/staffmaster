<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Export Payrun</h4>
		</div>
		<div class="col-md-12">
			<form id="create-payrun-form">
			<input type="hidden" name="type" value="<?=$type;?>" />
			<div class="modal-body">
				<div class="form-group alert alert-info">
					<input type="checkbox" checked /> &nbsp; Export to CSV
				</div>
				<div class="form-group">
					<button id="add-save-payrun" type="button" class="btn btn-core"><i class="fa fa-save"></i> Save & Export Pay Run</button>
				</div>
			</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
$(function(){
	$('#add-save-payrun').click(function(){
		save_payrun();
	})
})
function save_payrun() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/create_payrun",
		data: $('#create-payrun-form').serialize(),
		success: function(html) {
			location.reload();
		}
	})
}
</script>