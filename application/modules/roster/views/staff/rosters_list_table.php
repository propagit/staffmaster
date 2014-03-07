<div class="table-responsive">
	<table class="table table-bordered table-hover table-middle" width="100%">
	<thead>
		<tr>
			<td class="center" width="40"><input type="checkbox" id="select_all_rosters" /></td>
			<th class="center">Date</th>
			<th>Client</th>
			<th>Venue</th>
			<th class="center">Start</th>
			<th class="center">Finish</th>
			<th class="center">Break</th>
			<th class="center">Brief</th>
			<th class="center">Status</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($rosters as $roster) { ?>
		<tr>
			<td class="center">
				<? if($roster['status'] == 1) { ?>
				<input type="checkbox" class="select_roster" value="<?=$roster['shift_id'];?>" />
				<? } ?>
			</td>
			<td width="65" class="wp-date">
				<span class="wk_day"><?=date('D', strtotime($roster['job_date']));?></span>
				<span class="wk_date"><?=date('d', strtotime($roster['job_date']));?></span>
				<span class="wk_month"><?=date('M', strtotime($roster['job_date']));?></span>
			</td>
			<td><? $client = modules::run('client/get_client', $roster['client_id']); echo $client['company_name']; ?></td>
			<td>
				<i class="fa fa-map-marker"></i> &nbsp; <a class="roster_venue" data-toggle="modal" data-target="#modal_map" href="<?=base_url();?>roster/ajax/load_roster_venue/<?=$roster['venue_id'];?>"><?=modules::run('attribute/venue/display_venue', $roster['venue_id']);?></a>
			</td>
			<td class="center"><?=date('H:i', $roster['start_time']);?></td>
			<td class="center"><?=date('H:i', $roster['finish_time']);?> <?=(date('d', $roster['finish_time']) != date('d', $roster['start_time'])) ? '<span class="error">*</span>': '';?></td>
			<td class="center"><?=modules::run('common/break_time', $roster['break_time']);?></td>
			<td class="center"><a href="#"><i class="fa fa-eye"></i></a></td>
			<td class="center" width="150">
				<? if($roster['status'] == 1) { ?>
				<div class="btn-group">
					<button type="button" class="btn btn-danger">Unconfirmed</button>
					<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li><a class="roster_confirm" data-shift-id="<?=$roster['shift_id'];?>">Confirm</a></li>
						<li><a class="roster_reject" data-shift-id="<?=$roster['shift_id'];?>">Reject</a></li>
					</ul>
				</div>
				<? } else if ($roster['status'] == 2) { ?>
				<span class="btn btn-success"><i class="fa fa-thumbs-o-up"></i> Confirmed</span>
				<? } else { ?>
				<span class="btn btn-core">Completed</span>
				<? } ?>
			</td>
		</tr>
	<? } ?>
	</tbody>
	</table>
</div>
<script>
$(function(){
	var selected_rosters = new Array();	
	$('#select_all_rosters').click(function(){
		$('input.select_roster').prop('checked', this.checked);
	})
	$('.multi_confirm').click(function(){
		selected_rosters.length = 0;
		$('.select_roster:checked').each(function(){
			selected_rosters.push($(this).val());
		});
		confirm_selected(selected_rosters);
	});
	$('.multi_reject').click(function(){
		selected_rosters.length = 0;
		$('.select_roster:checked').each(function(){
			selected_rosters.push($(this).val());
		});
		reject_selected(selected_rosters);
	});
	
	$('.roster_reject').click(function(){
		selected_rosters.length = 0;
		selected_rosters.push($(this).attr('data-shift-id'));
		reject_selected(selected_rosters);
	});
	$('.roster_confirm').click(function(){
		selected_rosters.length = 0;
		selected_rosters.push($(this).attr('data-shift-id'));
		confirm_selected(selected_rosters);
	});
})
</script>