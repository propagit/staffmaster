<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Export Staff</h4>
		</div>
		<div class="col-md-12">
			<form id="export-staff-form">
			<input type="hidden" name="user_ids" value="<?=$user_ids;?>" />
			<div class="modal-body">
				<div id="export_templates" class="form-group alert alert-info clearfix">
					<?=modules::run('staff/field_select_export_templates', 'export_id');?>
				</div>
				<div class="form-group">
					<button id="export-staff" type="button" class="btn btn-core"><i class="fa fa-download"></i> Export Staff</button>
				</div>
				
			</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#export-staff').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>staff/ajax/exporting",
			data: $('#export-staff-form').serialize(),
			success: function(html) {
				if (!html) {
					$('#export_templates').addClass('has-error');
					return;
				}
				window.location = '<?=base_url();?>exports/staff/' + html;
				$('.bs-modal-lg').modal('hide');
			}
		})
	})
})
</script>