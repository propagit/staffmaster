<div class="table-responsive">
	<table class="table table-bordered table-hover" width="100%">
	<thead>
		<tr>
			<td class="wp-date"><input type="checkbox" class="select_day" /></td>
			<th>Client</th>
			<th>Role</th>
			<th>Venue</th>
			<th class="center">Start</th>
			<th class="center">Finish</th>
			<th class="center">Break</th>
			<th class="center">Pay Rate</th>
			<th class="center">Brief</th>
			<th class="center" width="100">Apply</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($shifts as $shift) { ?>
	<tr>
		<td class="wp-date"><input type="checkbox" class="select_shift" value="<?=$shift['shift_id'];?>" /></td>
		<td width="180"><? $client = modules::run('client/get_client', $shift['client_id']); echo $client['company_name']; ?></td>
		<td width="180"><?=modules::run('attribute/role/display_role', $shift['role_id']);?></td>
		<td>
			<? if ($shift['venue_id']) { ?>			
			<a data-toggle="modal" data-target=".bs-modal-sml" href="<?=base_url();?>common/ajax/load_venue_map/<?=$shift['venue_id'];?>"><i class="fa fa-map-marker"></i> &nbsp; <?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></a>			
			<? } else { ?>
			Not Specified
			<? } ?>
		</td>
		<td class="center" width="100"><?=date('H:i', $shift['start_time']);?></td>
		<td class="center" width="100"><?=date('H:i', $shift['finish_time']);?> <?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="error">*</span>': '';?></td>
		<td class="center" width="80"><?=modules::run('common/break_time', $shift['break_time']);?></td>
		<td class="center" width="150"><?=modules::run('attribute/payrate/display_payrate', $shift['payrate_id']);?></td>
		<td class="center" width="50"><a target="_blank" href="<?=base_url();?>brief/view_brief/<?=$shift['shift_id'];?>"><i class="fa fa-eye"></i></a></td>
		<td class="center" width="60">
			<? 
			if(modules::run('work/ajax/is_shift_applied', $shift['shift_id'])) { ?>			
			<a class="unapply_shift_<?=$date;?> btn btn-xs btn-success" data-shift-id="<?=$shift['shift_id'];?>"><i class="fa fa-thumbs-o-up"></i> Applied</a>
			<? } else { ?>
			<a class="apply_shift btn btn-xs btn-core" data-shift-id="<?=$shift['shift_id'];?>"><i class="fa fa-thumbs-o-up"></i> Apply</a>
			<? } ?>
		</td>
	</tr>
	<? } ?>
	</tbody>
	</table>
</div>

<script>
$(function(){
	$('.apply_shift').click(function(){
		var selected_shifts = new Array();
		selected_shifts.push($(this).attr('data-shift-id'));
		apply_shifts(selected_shifts);
	});
	$('.select_day').click(function(){
		$(this).parent().parent().parent().parent().find('input.select_shift').prop('checked', this.checked);
	});
	$('.unapply_shift_<?=$date;?>').confirmModal({
		confirmTitle: 'Withdrawl this job',
		confirmMessage: 'Are you sure you want to withdrawl this job?',
		confirmCallback: function(e) {
			var shift_id = $(e).attr('data-shift-id');
			unapply_shift(shift_id);
		}
	})
})
</script>