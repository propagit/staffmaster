<? if (count($invoices) == 0) { ?>
<div class="alert alert-warning">No invoices</div>
<? } else { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"></th>
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
		<td class="center"><input type="checkbox" /></td>
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
</div>
<? } ?>