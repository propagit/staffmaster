<table width="100%" cellpadding="5" style="border-collapse:collapse; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
	<thead>
		<tr style="background:#ededed;">
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Date</th>
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Venue</th>
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Role</th>
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Uniform</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Start Time</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Finish Time</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Break</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Status</th>
		</tr>
	</thead>
	<tbody>
    <? if(count($rosters)){ ?>
	<? foreach($rosters as $roster) { ?>
		<tr>
			<td align="left" style="border:1px solid #ccc;"><?=date('d M', strtotime($roster['job_date']));?></td>
			<td align="left" style="border:1px solid #ccc;">
				<? if ($roster['venue_id']) { 
				$venue = modules::run('attribute/venue/get_venue', $roster['venue_id']);
				$address = $venue['address'] . ', ' . $venue['suburb'] . ' ' . $venue['state'] . ' ' . $venue['postcode'];
				?>			
				<?=modules::run('attribute/venue/display_venue', $roster['venue_id']);?>	
				<br />
				Address: <a href="http://maps.google.com.au/?q=<?=$address;?>"><?=$address;?></a>
				<? } else { ?>
				Not Specified
				<? } ?>
			</td>
			<td align="left" style="border:1px solid #ccc;">
				<?=modules::run('attribute/role/display_role', $roster['role_id']);?>
			</td>
			<td align="left" style="border:1px solid #ccc;">
				<?=modules::run('attribute/uniform/display_uniform', $roster['uniform_id']);?>
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
	<? } }else { ?>
    	<tr>
        	<td align="center" colspan="6" style="border:1px solid #ccc;">Your roster is empty</td>
        </tr>
    <?php } ?>
	</tbody>
</table>