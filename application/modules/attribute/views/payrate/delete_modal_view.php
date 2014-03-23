<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Delete Pay Rate: <?=$payrate['name'];?></h4>
		</div>
		<div class="col-md-12">
			<? if($shifts_count + $timesheets_count > 0) { ?>
			<div class="alert alert-danger">
				<? if ($shifts_count > 0) { ?>
				There are <b><?=$shifts_count;?> shifts</b> using this pay rate.<br />
				<? } ?>
				<? if ($timesheets_count > 0) { ?>
				There are <b><?=$timesheets_count;?> timesheets</b> using this pay rate.<br />
				<? } ?>
				Are you sure you want to delete this pay rate?
			</div>
			<? } else { ?>
			<div class="modal-body">
				Are you sure you want to delete this pay rate?
			</div>
			<? } ?>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary" data-dismiss="ok" id="btn-delete-payrate">Delete</button>
			<button class="btn btn-default" data-dismiss="modal">Cancel</button>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	$('#btn-delete-payrate').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>attribute/ajax_payrate/delete_payrate",
			data: {payrate_id: <?=$payrate['payrate_id'];?>},
			success: function(html) {
				location.reload();
			}
		})
	})
})
</script>