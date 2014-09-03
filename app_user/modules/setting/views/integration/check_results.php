<h2><?=ucwords($type);?> Summary</h2>
<br />
<div id="platform-data" class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
	<thead>
		<tr>
			<th></th>
			<th class="center">Total</th>
			<th class="center">Not Synced</th>
			<th class="center">Synced</th>
			<th class="center">Warning</th>
		</tr>
	</thead>
	<tbody>
	<tr>
		<td align="left"><b><?=$platform;?></b></td>
		<td><span class="badge badge-default"><?=$total_shoebooks;?></span></td>
		<td>
			<span class="badge warning" id="not_synced"><?=$total_shoebooks - $synced;?></span>
			<? if($total_shoebooks > $synced) { ?>
			<a onclick="download_not_synced()"><i class="fa fa-download"></i></a>
			<? } ?>
		</td>
		<td rowspan="2"><span class="badge success"><?=$synced;?></span></td>
		<td rowspan="2">
			<span id="synced_warning" class="badge danger"><?=count($warnings);?></span>
			<? if(count($warnings) > 0) { ?>
			<a onclick="download_report()"><i class="fa fa-download"></i></a>
			<? } ?>
		</td>
	</tr>
	<tr>
		<td align="left"><b>StaffBooks</b></td>
		<td><span class="badge badge-default"><?=$total_staffbooks;?></span></td>
		<td>
			<span class="badge warning" id="not_synced_staffbooks"><?=$total_staffbooks - $synced;?></span>
			<? if ($total_staffbooks > $synced) { ?>
			<a onclick="download_not_synced_staffbooks()"><i class="fa fa-download"></i></a>
			<? } ?>
		</td>
	</tr>
	</tbody>
</table>
</div>

<p><a class="btn btn-danger" onclick="close_waiting_modal()"><i class="fa fa-times"></i> Close</a></p>

<script>
$(function(){
	<? if($total_shoebooks > $synced) { ?>
	$('#not_synced').popover({
		content: 'There are <?=($total_shoebooks - $synced) . ' ' . $type;?> in <?=$platform;?> were not synced with StaffBooks because the External ID is not found in StaffBooks. Click the icon to download the list for more details.',
		title: 'What is it?',
		trigger: 'hover'
	})
	<? } ?>
	
	<? if($total_staffbooks > $synced) { ?>
	$('#not_synced_staffbooks').popover({
		content: 'There are <?=($total_staffbooks - $synced) . ' ' . $type;?> in StaffBooks that are not found in <?=$platform;?>. Click the icon to download the list for more details.',
		title: 'What is it?',
		trigger: 'hover'
	})
	<? } ?>
	
	<? if(count($warnings) > 0) { ?>
	$('#synced_warning').popover({
		content: 'There are <?=count($warnings) . ' ' . $type;?> in <?=$platform;?> and StaffBooks that have the same External ID but different name. Click the icon to download the report for more details.',
		title: 'What is it?',
		trigger: 'hover'
	})
	<? } ?>
})
function download_report() {
	$('#loadingModal').modal('show');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>setting/ajax/download_<?=strtolower($platform);?>_<?=$type;?>_report",
		data: {ids: '<?=serialize($warnings);?>'},
		success: function(html) {
			$('#loadingModal').modal('hide');
			window.location = '<?=base_url().EXPORTS_URL;?>/error/' + html;
		}
	})
}
function download_not_synced()
{
	$('#loadingModal').modal('show');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>setting/ajax/download_not_synced_<?=$type;?>_<?=strtolower($platform);?>",
		data: {},
		success: function(html) {
			$('#loadingModal').modal('hide');
			window.location = '<?=base_url().EXPORTS_URL;?>/error/' + html;
		}
	})
}
function download_not_synced_staffbooks()
{
	$('#loadingModal').modal('show');
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>setting/ajax/download_not_synced_<?=$type;?>_<?=strtolower($platform);?>_staffbooks",
		data: {},
		success: function(html) {
			$('#loadingModal').modal('hide');
			window.location = '<?=base_url().EXPORTS_URL;?>/error/' + html;
		}
	})
}
</script>