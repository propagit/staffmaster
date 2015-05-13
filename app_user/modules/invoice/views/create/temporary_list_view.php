<? if (count($invoices) == 0) { ?>
<div class="alert alert-warning">No invoices</div>
<? } else { ?>

<?
	# Action menu
	$data = array(
		array('value' => 'generate', 'label' => '<i class="fa fa-check-circle"></i> Generate Invoice')
	);
	echo modules::run('common/menu_dropdown', $data, 'invoice-action', 'Actions');
?>
<div class="table-responsive">
<form id="invoice-bulk-action-form">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"><input type="checkbox" id="master-checkbox" /></th>
		<th>Client</th>
		<th class="center" width="200">Time Sheets</th>
		<th class="center" width="120">Expenses</th>
		<th class="center" width="120">Amount</th>
		<th class="center" width="160">Preview</th>
	</tr>
	</thead>
    
	<tbody>

	<? foreach($invoices as $invoice) { ?>
	<tr>
		<td class="center"><input type="checkbox" name="selected_user_ids[]" value="<?=$invoice['user_id'];?>" class="checkbox-multi-action" /> </td>
		<td><?=$invoice['company_name'];?></td>
		<td class="center"><?=$invoice['total_timesheets'];?></td>
		<td class="center">
			$<?=money_format('%i', $invoice['expenses']);?>
		</td>
		<td class="center">$<?=money_format('%i', $invoice['total_amount']);?></td>
		<td class="center">
			<a href="<?=base_url();?>invoice/create/<?=$invoice['user_id'];?>" target="_blank"><i class="fa fa-eye"></i></a>
		</td>
	</tr>
	<? } ?>
   
	</tbody>
    
</table>
</form>
</div>
<? } ?>

<script>
$(function(){
	//check uncheck all checkboes
	help.toggle_checkboxes('#master-checkbox','.checkbox-multi-action');	
	
	$('#menu-invoice-action ul li a').on('click',function(){
		var checked = false;
		$('.checkbox-multi-action').each(function(){
			if(this.checked){
				checked = true;
				return false;
			}
		})
		if(checked){
			var action = $(this).attr('data-value');
			perform_multi_update(action);
		}
	})
});
</script>