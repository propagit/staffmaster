<table width="100%" border="1" cellpadding="5">
	<thead>
		<tr>
			<th align="left">Date</th>
			<th align="left">Venue</th>
			<th align="center">Start Time</th>
			<th align="center">Finish Time</th>
			<th align="center">Break</th>
			<th align="center">Status</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($rosters as $roster) { ?>
		<tr>
			<td align="left"><?=date('d M', strtotime($roster['job_date']));?></td>
			<td align="left">
				<? if ($roster['venue_id']) { ?>			
				<?=modules::run('attribute/venue/display_venue', $roster['venue_id']);?>		
				<? } else { ?>
				Not Specified
				<? } ?>
			</td>
			<td align="center"><?=date('H:i', $roster['start_time']);?></td>
			<td align="center"><?=date('H:i', $roster['finish_time']);?> <?=(date('d', $roster['finish_time']) != date('d', $roster['start_time'])) ? '*': '';?></td>
			<td align="center"><?=modules::run('common/break_time', $roster['break_time']);?></td>
			<td align="center">
				<? if($roster['status'] == 1) { ?>
				Unconfirmed
				<? } else if ($roster['status'] == 2) { ?>
				Confirmed
				<? } else { ?>
				Completed
				<? } ?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>