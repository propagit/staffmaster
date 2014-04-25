<table width="100%" cellpadding="5" style="border-collapse:collapse; font-size:12px; font-family:Arial, Helvetica, sans-serif;">
	<thead>
		<tr style="background:#ededed;">
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Date</th>
            <th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Role</th>
			<th align="left" style="border:1px solid #ccc;padding: 12px 5px;">Venue</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Start Time</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Finish Time</th>
			<th align="center" style="border:1px solid #ccc;padding: 12px 5px;">Break</th>
		</tr>
	</thead>
	<tbody>
	<? foreach($shifts as $shift) { ?>
		<tr>
			<td align="left" style="border:1px solid #ccc;"><?=date('d M', strtotime($shift['job_date']));?></td>
            <td align="center" style="border:1px solid #ccc;">
				<? if($shift['role_id']){?>
                <?=modules::run('attribute/role/get_role_name',$shift['role_id']);?>
                <? } else { ?>
				Not Specified
				<? } ?>
            </td>
			<td align="left" style="border:1px solid #ccc;">
				<? if ($shift['venue_id']) { ?>			
				<?=modules::run('attribute/venue/display_venue', $shift['venue_id']);?>		
				<? } else { ?>
				Not Specified
				<? } ?>
			</td>
			<td align="center" style="border:1px solid #ccc;"><?=date('H:i', $shift['start_time']);?></td>
			<td align="center" style="border:1px solid #ccc;"><?=date('H:i', $shift['finish_time']);?> <?=(date('d', $shift['finish_time']) != date('d', $shift['start_time'])) ? '*': '';?></td>
			<td align="center" style="border:1px solid #ccc;"><?=modules::run('common/break_time', $shift['break_time']);?></td>
		</tr>
	<? } ?>
	</tbody>
</table>