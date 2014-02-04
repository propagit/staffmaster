<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Book Me</h4>
		</div>
		<div class="modal-body">
			<div class="box">
				<p><?=count($staffs);?> staff has applied for this shift</p>
				<div class="table-responsive">                     
				<table class="table table-bordered table-hover" width="100%">
				<tbody>
					<? foreach($staffs as $staff) { ?>
					<tr>
						<td>
							<a class="photo_staff photo_45 pull-left"></a>
							<a><?=$staff['first_name'];?> <?=$staff['last_name'];?></a>
						</td>
						<td width="50"><a onclick="assign_new_staff(<?=$staff['user_id'];?>)" class="btn btn-lg btn-core"><i class="fa fa-plus"></i> Add</a></td>
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
		url: "<?=base_url();?>job/ajax/assign_new_staff",
		data: {user_id: user_id},
		success: function(html) {
			load_job_shifts();
		}
	})
}
</script>