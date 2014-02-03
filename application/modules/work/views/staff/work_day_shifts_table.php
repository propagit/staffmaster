<div class="table-responsive">
	<table class="table table-bordered table-hover" width="100%">
	<thead>
		<tr>
			<td class="wp-date"><input type="checkbox" id="select_day_<?=$date;?>" /></td>
			<th>Client</th>
			<th>Role</th>
			<th>Venue</th>
			<th class="center">Start</th>
			<th class="center">Finish</th>
			<th class="center">Break</th>
			<th class="center">Pay</th>
			<th class="center">Brief</th>
			<th class="center" width="100">Apply</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($shifts as $shift) { ?>
	<tr>
		<td class="wp-date"><input type="checkbox" class="select_shift" value="<?=$shift['shift_id'];?>" /></td>
		<td><? $client = modules::run('client/get_client', $shift['client_id']); echo $client['company_name']; ?></td>
		<td><?=modules::run('attribute/role/display_role', $shift['role_id']);?></td>
		<td><i class="fa fa-map-marker"></i> &nbsp; <a data-toggle="modal" data-target="#modal_map" href="<?=base_url();?>roster/ajax/load_roster_venue/<?=$shift['venue_id'];?>"><?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?></a></td>
		<td class="center"><?=date('H:i', $shift['start_time']);?></td>
		<td class="center"><?=date('H:i', $shift['finish_time']);?> <?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '<span class="error">*</span>': '';?></td>
		<td class="center"><?=modules::run('common/break_time', $shift['break_time']);?></td>
		<td class="center"></td>
		<td class="center"><a href="#"><i class="fa fa-eye"></i></a></td>
		<td class="center">
			<? 
			if(modules::run('work/ajax/is_shift_applied', $shift['shift_id'])) { ?>			
			<span class="btn btn-xs btn-success"> <i class="fa fa-thumbs-o-up"></i> Applied</span>
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
	})
	$('#select_day_<?=$date;?>').click(function(){
		$(this).parent().parent().parent().parent().find('input.select_shift').prop('checked', this.checked);
	})
})
</script>