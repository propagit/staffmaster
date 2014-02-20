<? if (count($invoices) == 0) { ?>
<div class="alert alert-warning">No invoices</div>
<? } else { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle">
	<thead>
	<tr>
		<th class="center" width="20"></th>
		<th>Client</th>
		<th class="center">Time Sheets</th>
		<th class="center">Expenses</th>
		<th class="center">Amount</th>
		<th class="center" width="40">Preview</th>
		<th class="center" width="40">Generate</th>
	</tr>
	</thead>
	<tbody>
	<? foreach($invoices as $invoice) { ?>
	<tr>
		<td class="center"><input type="checkbox" /></td>
		<td><?=$invoice['company_name'];?></td>
		<td class="center"><?=$invoice['total_timesheets'];?></td>
		<td class="center"></td>
		<td class="center">$<?=money_format('%i', $invoice['total_amount']);?></td>
		<td class="center"><i class="fa fa-eye"></i></td>
		<td class="center"><i class="fa fa-check"></i></td> 
	</tr>
	<? } ?>
	</tbody>
</table>
</div>
<? } ?>