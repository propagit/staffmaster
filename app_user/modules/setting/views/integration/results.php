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
		<td align="left"><b><?=$platform;?></b></td>
		<td><span class="badge badge-default"><?=$total;?></span></td>
		<td><span class="badge primary"><?=$total - $old;?></span></td>
		<td><span class="badge success"><?=$imported;?></span></td>
		<td><span class="badge danger" id="error-<?=$platform;?>"><?=($error = $total - $old - $imported);?></span></td>
	</tr>
	<tr>
		<td align="left"><b>StaffBooks</b></td>
		<td><span class="badge badge-default"><?=$staffbooks_total;?></span></td>
		<td><span class="badge primary"><?=$exported;?></span></td>
		<td><span class="badge success"><?=$exported + $updated;?></span></td>
		<td><span class="badge danger" id="error-staffbooks"><?=$errors;?></span></td>
	</tr>
	</tbody>
</table>
</div>

<p><a class="btn btn-danger" onclick="location.reload()"><i class="fa fa-times"></i> Close</a></p>

<script>
$(function(){
	
	<? if($error > 0) { ?>
	$('#error-<?=$platform;?>').popover({
		content: '<?=$type;?> in <?=$platform;?> that have no card ID or a card ID set as *None cannot be imported. To import these <?=$type;?> update the card ID in <?=$platform;?> to a unique identifier and sync again.',
		title: 'Why is it?',
		trigger: 'hover'
	})
	<? } ?>
	<? if($errors > 0) { ?>
	$('#error-staffbooks').popover({
		content: 'The connection to <?=$platform;?> may have timed out trying to sync with <?=$platform;?>. Try to sync again to bring these <?=$type;?> across. If the problem persists contact StaffBooks support by posting a support ticket via "System Settings > Support"',
		title: 'Why is it?',
		trigger: 'hover'
	})
	<? } ?>
})
</script>