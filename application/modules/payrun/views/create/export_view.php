<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Generate Pay Run</h4>
		</div>
		<div class="col-md-12">
			<form id="create-payrun-form">
			<input type="hidden" name="type" value="<?=$type;?>" />
			<div class="modal-body">
				<div class="form-group alert alert-info clearfix">
					<input type="checkbox" id="check_to_export" checked /> &nbsp; Export to CSV
					<h2 id="export_templates" class="hide">
						<?=modules::run('payrun/field_select_export_templates', $type, 'export_id');?>
					</h2>
				</div>
				<div class="form-group">
					<button id="add-save-payrun" type="button" class="btn btn-core">Generate Pay Run</button>
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
	});
	$('#check_to_export').click(function(){
		include_export();
	});
	include_export();
})
function include_export() {
	if ($('#check_to_export').is(':checked')) {
		$('#add-save-payrun').html('Generate and Export Pay Run');
		$('#export_templates').removeClass('hide');
	} else {
		$('#add-save-payrun').html('Generate Pay Run');
		$('#export_templates').addClass('hide');
	}
}
function save_payrun() {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>payrun/ajax/create_payrun",
		data: $('#create-payrun-form').serialize(),
		success: function(data) {
			data = $.parseJSON(data);
			if (data.export) {
				if (!data.success) {
					$('#export_templates').addClass('has-error');
					return;
				} else {
					window.location = '<?=base_url();?>exports/payrun/' + data.file_name;
				}
				
			}
			$('.bs-modal-lg').modal('hide');
			list_staffs();
			get_payrun_stats();
		}
	})
}
</script>