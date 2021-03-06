<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Export Payrun</h4>
		</div>
		<div class="col-md-12">
			<form id="export-payrun-form">
			<input type="hidden" name="payrun_id" value="<?=$payrun['payrun_id'];?>" />
			<div class="modal-body">
				<div id="export_templates" class="form-group alert alert-info clearfix">
					<?=modules::run('payrun/field_select_export_templates', $payrun['type'], 'export_id');?>
				</div>
				<div class="form-group">
					<button id="export-payrun" type="button" class="btn btn-core"><i class="fa fa-download"></i> Export Pay Run</button>
				</div>
				
			</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
$(function(){
	$('#export-payrun').click(function(){
		$('.bs-modal-lg').modal('hide');
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>payrun/ajax/exporting",
			data: $('#export-payrun-form').serialize(),
			success: function(html) {
				if (!html) {
					$('#export_templates').addClass('has-error');
					return;
				}
				$('#waitingModal').modal('hide');
				window.location = '<?=base_url().EXPORTS_URL;?>/payrun/' + html;
			
			}
		})
	})
	$('#waitingModal').modal({
		backdrop: 'static',
		keyboard: true,
		show: false
	})
})
</script>