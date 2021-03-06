<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Export Expenses</h4>
		</div>
		<div class="col-md-12">
			<form id="export-expense-form">
			<input type="hidden" name="ids" value="<?=$ids;?>" />
			<div class="modal-body">
				<div class="form-group alert alert-info clearfix">
					<div id="export_templates">
						<?=modules::run('expense/field_select_export_templates', 'export_id');?>
					</div><br /><br />
					<input type="checkbox" name="mark_as_paid" value="1" checked /> &nbsp; Mark as Paid
				</div>
				
				<div class="form-group">
					<button id="export-expense" type="button" class="btn btn-core"><i class="fa fa-download"></i> Export Expenses</button>
				</div>
				
			</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#export-expense').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>expense/ajax/exporting",
			data: $('#export-expense-form').serialize(),
			success: function(html) {
				if (!html) {
					$('#export_templates').addClass('has-error');
					return;
				}
				window.location = '<?=base_url().EXPORTS_URL;?>/expense/' + html;
				search_expenses();
				$('.bs-modal-lg').modal('hide');
			}
		})
	})
})
</script>