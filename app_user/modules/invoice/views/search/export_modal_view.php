<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Export Invoices</h4>
		</div>
		<div class="col-md-12">
			<form id="export-invoice-form">
			<input type="hidden" name="ids" value="<?=$ids;?>" />
			<div class="modal-body">
				<div class="form-group alert alert-info clearfix">
					<div id="export_templates">
						<?=modules::run('invoice/field_select_export_templates', 'export_id');?>
					</div><br /><br />
					<input type="checkbox" name="mark_as_paid" value="1" checked /> &nbsp; Mark as Paid
				</div>
				
				<div class="form-group">
					<button id="export-invoice" type="button" class="btn btn-core"><i class="fa fa-download"></i> Export Invoices</button>
				</div>
				
			</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#export-invoice').click(function(){
		$('.bs-modal-lg').modal('hide');
		$('#waitingModal').modal('show');
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>invoice/ajax/exporting",
			data: $('#export-invoice-form').serialize(),
			success: function(html) {
				if (!html) {
					$('#export_templates').addClass('has-error');
					return;
				}
				$('#waitingModal').modal('hide');
				window.location = '<?=base_url().EXPORTS_URL;?>/invoice/' + html;
				search_invoices();
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