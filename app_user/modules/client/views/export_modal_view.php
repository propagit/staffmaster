<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
			<h4 class="modal-title">Export Client</h4>
		</div>
		<div class="col-md-12">
			<form id="export-client-form">
			<input type="hidden" name="user_ids" value="<?=$user_ids;?>" />
			<div class="modal-body">
				<div id="export_templates" class="form-group alert alert-info clearfix">
					<?=modules::run('client/field_select_export_templates', 'export_id');?>
				</div>
				<div class="form-group">
					<button id="export-client" type="button" class="btn btn-core"><i class="fa fa-download"></i> Export Client</button>
				</div>
				
			</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#export-client').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>client/ajax/exporting",
			data: $('#export-client-form').serialize(),
			success: function(html) {
				alert(html);
				if (!html) {
					$('#export_templates').addClass('has-error');
					return;
				}
				window.location = '<?=base_url().EXPORTS_URL;?>/client/' + html;
				$('.bs-modal-lg').modal('hide');
			}
		})
	})
})
</script>