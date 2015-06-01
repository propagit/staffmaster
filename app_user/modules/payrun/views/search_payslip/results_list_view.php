<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($payslips);?></b> results</p>

<? if (count($payslips) > 0) { ?>
<div id="nav_payslip">
<?
	# Action menu
	$data = array(
		#array('value' => 'mark_deleted', 'label' => 'Mark Selected as Deleted')
	);
	if (count($data) > 0) 
	{
		echo modules::run('common/menu_dropdown', $data, 'payslip-action', 'Actions');
	}
?>
</div>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" id="selected_all_payslips" /></th>
		<th>External ID</th>
		<th class="center">From</th>
		<th class="center">To</th>
		<th class="center">Processed</th>
		<th>Staff Name</th>
		<th>Venue</th>
		<th class="center">Start - Finish</th>
		<th class="center">Break</th>
		<th>Pay Rate</th>
		<th class="center">Total Hours</th>
		<th class="center">Amount</th>
		<th class="center" width="40">View</th>
		<th class="center" width="40">Email</th>
	</tr>
</thead>
<tbody>
<? 
$accounting_platform = $this->config_model->get('accounting_platform');
foreach($payslips as $payslip) { 
	$external_id = $payslip['external_id'];
	
	if($accounting_platform == 'xero'){
		if($payslip['external_msg']){
			$msg_arr = json_decode($payslip['external_msg']);
			#print_r($msg_arr);
			$external_id = "<span>" . $msg_arr->msg . "</span><br>
							<span style='font-size:11px;'>Pay period: &nbsp;&nbsp;" . $msg_arr->pay_period_from . " - " . $msg_arr->pay_period_to . "</span>"; 	
		}
}
?>
	<tr>
		<td><input type="checkbox" class="selected_payslip" value="<?=$payslip['timesheet_id'];?>" /></td>
		<td><?=$external_id;?></td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', $payslip['start_time']);?></span>
			<span class="wk_date"><?=date('d', $payslip['start_time']);?></span>
			<span class="wk_month"><?=date('M', $payslip['start_time']);?></span>
		</td>		
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', $payslip['finish_time']);?></span>
			<span class="wk_date"><?=date('d', $payslip['finish_time']);?></span>
			<span class="wk_month"><?=date('M', $payslip['finish_time']);?></span>
		</td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($payslip['staff_paid_on']));?></span>
			<span class="wk_date"><?=date('d', strtotime($payslip['staff_paid_on']));?></span>
			<span class="wk_month"><?=date('M', strtotime($payslip['staff_paid_on']));?></span>
		</td>
		<td><?=$payslip['first_name']. ' ' . $payslip['last_name'];?></td>
		<td><?=$payslip['name'];?></td>
		<td class="center">
			<?=date('H:i', $payslip['start_time']);?> - <?=date('H:i', $payslip['finish_time']);?> <?=(date('d', $payslip['finish_time']) != date('d', $payslip['start_time'])) ? '<span class="text-danger">*</span>': '';?>
			(<?=($payslip['finish_time'] - $payslip['start_time']) / 3600;?>h)
		</td>
		<td class="center"><?=modules::run('common/break_time', $payslip['break_time']);?></td>
		<td class="center"><?=modules::run('attribute/payrate/display_payrate', $payslip['payrate_id']);?></td>
		<td class="center"><?=$payslip['total_minutes']/60;?></td>
		<td class="center">$<?=$payslip['total_amount_staff'];?></td>
		<td class="center">
			<a class="prim-color-to-txt-color prim-color-to-txt-color" data-toggle="modal" data-target=".bs-modal-lg" href="<?=base_url();?>timesheet/ajax/details/<?=$payslip['timesheet_id'];?>"><i class="fa fa-eye"></i></a>
		</td>
		<td class="center"><a><i class="fa fa-envelope-o"></i></a></td>
	</tr>
<? } ?>
</tbody>
</table>
<? } ?>
<script>
$(function(){
	var selected_payslips = new Array();
	$('#selected_all_payslips').click(function(){
		$('input.selected_payslip').prop('checked', this.checked);		
	});
	$('#menu-payslip-action ul li a[data-value="mark_deleted"]').confirmModal({
		confirmTitle: 'Delete selected payslips',
		confirmMessage: 'Are you sure you want to delete selected payslips?',
		confirmCallback: function(e) {
			selected_payslips.length = 0;
			$('.selected_payslip:checked').each(function(){
				selected_payslips.push($(this).val());
			});
			$.ajax({
				type: "POST",
				url: base_url + 'payrun/ajax/delete_payslips',
				data: {timesheets: selected_payslips},
				success: function(html) {
					search_payslips();
				}
			})
		}
	});
});
</script>