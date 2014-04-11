<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Book Me | Request Staff</h4>
		</div>
		<div class="col-md-12">
			<div class="modal-body">
				<h4 class="modal-body-title">Staff Applied</h4>
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
						<? if (!modules::run('auth/is_client')) { ?>
						<td width="50">
							<? if ($shift['staff_id'] == $staff['user_id'] || $this->staff_model->check_staff_time_collision($staff['user_id'], $shift)) { ?>							
							<span class="btn btn-default" disabled="disabled">Allocated</span>
							<? } else { ?>
							<a onclick="assign_new_staff(<?=$staff['user_id'];?>)" class="btn btn-core"><i class="fa fa-plus"></i> Assign</a>
							<? } ?>
						</td>
						<? } ?>
					</tr>
					<? } ?>
				</tbody>
				</table>
				</div>
				
				<h4 class="modal-body-title"><? if (!modules::run('auth/is_client')) { ?>Client - <? } ?>Request Staff</h4>
				<? if (modules::run('auth/is_client')) { ?>
				<p>Request one of our staff to fill this shift</p>
				<form role="form" id="form_update_shift_staff">
					<div class="form-group pull-left" id="f_shift_staff">
						<input type="hidden" name="shift_staff_id" value="" />
						<input type="hidden" name="shift_id" value="<?=$shift['shift_id'];?>" />
						<input type="text" class="shift_staff form-control" name="shift_staff" placeholder="Type staff name..." />
					</div>
				</form>
				
				<div id="staff_quick_search_result">
					
				</div>
				
				<button type="button" class="btn btn-primary btn-sm staff-submit">
					<i class="glyphicon glyphicon-ok"></i>
					</button>
				<button type="button" class="btn btn-default btn-sm staff-cancel">
					<i class="glyphicon glyphicon-remove"></i>
				</button>
				<? } ?>
				<br />
				<div id="list_requests">
				</div>
				
			</div>		
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
$(function(){
	get_request_staffs();
	$('.shift_staff').on('input', function(){
		var query = $(this).val();
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax/search_staff_for_shift",
			data: {query: query},
			success: function(html)
			{
				$('#staff_quick_search_result').html(html);
			}
		})
	});
	$('.staff-cancel').click(function(){
		$('#form_update_shift_staff').trigger("reset");
		$('#staff_quick_search_result').html('');
	});
	$('.staff-submit').click(function(){
		$.ajax({
			type: "POST",
			url: "<?=base_url();?>job/ajax_shift/request_staff",
			data: $('#form_update_shift_staff').serialize(),
			success: function(data) {
				data = $.parseJSON(data);
				if (!data.ok)
				{	
					$('#f_shift_staff').addClass('has-error');
				}
				else
				{
					get_request_staffs();
				}
			}
		})
	})
})
function get_request_staffs() {
	preloading($('#list_requests'));
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/get_request_staffs",
		data: {shift_id: <?=$shift['shift_id'];?>},
		success: function(html) {
			loaded($('#list_requests'), html);
		}
	})
}
function assign_new_staff(user_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax/update_shift_staff",
		data: {shift_id: <?=$shift_id;?>, shift_staff_id: user_id, shift_staff: true, status: <?=SHIFT_UNCONFIRMED;?>},
		success: function(html) {
			load_job_shifts(<?=$shift['job_id'];?>);
			$('.bs-modal-lg').modal('hide');
		}
	})
}
function remove_request(shift_id, staff_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>job/ajax_shift/remove_request",
		data: {shift_id: shift_id, staff_id: staff_id},
		success: function(html) {
			get_request_staffs();
		}
	})
}
</script>