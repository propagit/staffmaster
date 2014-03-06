<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Book Me</h4>
		</div>
		<div class="col-md-12">
			<div class="modal-body">
				<p><?=count($staffs);?> staff has applied for this shift</p>
				<div class="table-responsive">                     
				<table class="table table-bordered table-middle" width="100%">
				<tbody>
					<? foreach($staffs as $staff) { ?>
					<tr>
						<td>
							<a class="wp_photo_30 pull-left">
								<?=modules::run('staff/profile_image', $staff['user_id']);?>
							</a>
							<a><?=$staff['first_name'];?> <?=$staff['last_name'];?></a>
							<?=modules::run('common/field_rating', 'rating', $staff['rating'],true);?>
						</td>
						<td width="50"><a onclick="assign_new_staff(<?=$staff['user_id'];?>)" class="btn btn-core"><i class="fa fa-plus"></i> Assign</a></td>
					</tr>
					<? } ?>
				</tbody>
				</table>
				</div>
			</div>		
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
function assign_new_staff(user_id)
{
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/update_shift_staff",
		data: {shift_id: <?=$shift_id;?>, shift_staff_id: user_id, shift_staff: true, status: <?=SHIFT_UNCONFIRMED;?>},
		success: function(html) {
			load_job_shifts();
		}
	})
}
</script>