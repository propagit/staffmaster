<?php
	# this check was done on view as this was added later on and adding on the controller required changing on two files
	$has_child = false;
	if($timesheet['child_timesheet_id']){
		$has_child = true;
	}
		
	$has_parent = false;
	if($timesheet['parent_timesheet_id']){
		$has_parent = true;
	}
?>

<tr class="success timesheets_staff_<?=$user_id;?> 
	<?=$has_child ? 'has-child-ts' : '';?> <?=$has_parent ? 'has-parent-ts' : '';?>" 
    id="timesheet_<?=$timesheet['timesheet_id'];?>" 
    data-child-id="<?=$timesheet['child_timesheet_id'];?>"
    data-parent-id="<?=$timesheet['parent_timesheet_id'];?>"
    >
	<td class="ts-split-link">
		<? if(!$has_parent) { ?><input type="checkbox" class="payrun_timesheet" name="payrun_timesheets[]" value="<?=$timesheet['timesheet_id'];?>" /><?php } ?>
	</td>
	<td class="wp-date" width="70">
		<span class="wk_day"><?=date('D', $timesheet['start_time']);?></span>
		<span class="wk_date"><?=date('d', $timesheet['start_time']);?></span>
		<span class="wk_month"><?=date('M', $timesheet['start_time']);?></span>
	</td>
	<td class="wp-date" width="70">
		<span class="wk_day"><?=date('D', $timesheet['finish_time']);?></span>
		<span class="wk_date"><?=date('d', $timesheet['finish_time']);?></span>
		<span class="wk_month"><?=date('M', $timesheet['finish_time']);?></span>
	</td>
	<td>
		<?=date('H:i', $timesheet['start_time']);?> - <?=date('H:i', $timesheet['finish_time']);?>
	</td>
	<td class="center"><?=modules::run('common/break_time', $timesheet['break_time']);?></td>
	<td class="center"><?=modules::run('attribute/payrate/display_payrate', $timesheet['payrate_id']);?></td>
	<td></td>
	<td class="center"><?=$timesheet['total_minutes']/60;?></td>
	<td class="center">$<?=$timesheet['total_amount_staff'];?></td>
	<td class="center">
    <? if(!$has_parent) { ?>
		<a class="editable-click" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/details/<?=$timesheet['timesheet_id'];?>"><i class="fa fa-eye"></i></a>
    <?php } ?>
	</td>
	<td class="center">
    <? if(!$has_parent) { ?>
		<div class="btn-group">
			<? if ($timesheet['status_payrun_staff'] == PAYRUN_READY) { ?>
			<button type="button" onclick="process_payrun(<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-success btn-yes">Yes</button>
			<button type="button" onclick="unprocess_payrun(<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-default btn-no">No</button>
			<? } else { ?>
			<button type="button" onclick="process_payrun(<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-default btn-yes">Yes</button>
			<button type="button" onclick="unprocess_payrun(<?=$timesheet['timesheet_id'];?>,<?=$user_id;?>)" class="btn btn-danger btn-no">No</button>
			<? } ?>
		</div>
    <?php } ?>
	</td>
	<td class="center">
    <? if(!$has_parent) { ?>
		<? if($timesheet['status_invoice_client'] < INVOICE_GENERATED) { ?>
		<a onclick="revert_payrun(<?=$timesheet['staff_id'];?>,<?=$timesheet['timesheet_id'];?>)"><i class="fa fa-times"></i></a>
		<? } else { ?>
		<a href="<?=base_url();?>invoice/view/<?=$timesheet['invoice_id'];?>" target="_blank" class="tooltip2" data-toggle="tooltip" title='The client has been invoiced for this shift. To revert this shift you need to revert the invoice. Click the "?" to view the invoice and click "Edit Invoice to revert the invoice. Invoices with a paid status cannot be reverted'><i class="fa text-danger fa-question"></i></a>
		<? } ?>
    <?php } ?>
	</td>
	<td></td>	
</tr>
<!-- Generated markup by the plugin -->
<div class="tooltip top" role="tooltip">
  <div class="tooltip-arrow"></div>
  <div class="tooltip-inner">
    Some tooltip text!
  </div>
</div>

<script>
$(function(){
	$('.tooltip2').tooltip({
		trigger: 'hover'
	})
})
</script>