<table width="100%" cellpadding="5" style="border-collapse:collapse; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
	<thead>
		<tr style="background:#ededed;">
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Date</th>
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Venue</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Start Time</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Finish Time</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Break</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Status</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($rosters as $roster) { ?>
		<tr>
			<td align="left" style="border:1px solid #ccc;"><?=date('d M', strtotime($roster['job_date']));?></td>
			<td align="left" style="border:1px solid #ccc;">
				<? if ($roster['venue_id']) { ?>			
				<?=modules::run('attribute/venue/display_venue', $roster['venue_id']);?>		
				<? } else { ?>
				Not Specified
				<? } ?>
			</td>
			<td align="center" style="border:1px solid #ccc;"><?=date('H:i', $roster['start_time']);?></td>
			<td align="center" style="border:1px solid #ccc;"><?=date('H:i', $roster['finish_time']);?> <?=(date('d', $roster['finish_time']) != date('d', $roster['start_time'])) ? '*': '';?></td>
			<td align="center" style="border:1px solid #ccc;"><?=modules::run('common/break_time', $roster['break_time']);?></td>
			<td align="center" style="border:1px solid #ccc;">
				<? if($roster['status'] == 1) { ?>
				<a href="<?=base_url();?>roster"><img src="<?=base_url();?>assets/img/core/roster-uncompleted-btn.jpg" /></a>
				<? } else if ($roster['status'] == 2) { ?>
				<a href="<?=base_url();?>roster"><img src="<?=base_url();?>assets/img/core/roster-confirmed-btn.jpg" /></a>
				<? } else { ?>
				<a href="<?=base_url();?>roster"><img src="<?=base_url();?>assets/img/core/roster-completed-btn.jpg" /></a>
				<? } ?>
			</td>
		</tr>
	<? } ?>
	</tbody>
</table>