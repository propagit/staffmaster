<h2><?=$type;?> Sync Results</h2>
<br />
<div id="platform-data" class="table-responsive">
	<table class="table table-bordered table-hover table-middle" width="100%">
	<thead>
		<tr>
			<th></th>
			<th class="center">Found</th>
			<th class="center">New</th>
			<th class="center">Synced</th>
			<th class="center">Errors</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td align="left"><b>MYOB</b></td>
		<td><span class="badge badge-default"><?=$myob_total;?></span></td>
		<td><span class="badge primary"><?=$myob_total - $myob_old;?></span></td>
		<td><span class="badge success"><?=$imported;?></span></td>
		<td><span class="badge danger" id="error-myob"><?=($myob_error = $myob_total - $myob_old - $imported);?></span></td>
	</tr>
	<tr>
		<td align="left"><b>StaffBooks</b></td>
		<td><span class="badge badge-default"><?=$staffbooks_total;?></span></td>
		<td><span class="badge primary"><?=$exported;?></span></td>
		<td><span class="badge success"><?=$exported + $updated;?></span></td>
		<td></td>
	</tr>
	</tbody>
</table>
</div>

<p><a class="btn btn-danger" onclick="location.reload()"><i class="fa fa-times"></i> Close</a></p>

<script>
$(function(){
	
	<? if($myob_error > 0) { ?>
	$('#error-myob').popover({
		content: '<?=$type;?> in MYOB that have no card ID or a card ID set as *None cannot be imported. To import these <?=$type;?> update the card ID in MYOB to a unique identifier and sync again.',
		title: 'Why is it?',
		trigger: 'hover'
	})
	<? } ?>
	<? if($errors > 0) { ?>
	$('#error-staffbooks').popover({
		content: 'The connection to MYOB may have timed out trying to sync with MYOB. Try to sync again to bring these <?=$type;?> across. If the problem persists contact StaffBooks support by posting a support ticket via "System Settings > Support"',
		title: 'Why is it?',
		trigger: 'hover'
	})
	<? } ?>
})
</script>