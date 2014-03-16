<hr />
<h2>Search Results</h2>
<p>Your search returned <b><?=count($invoices);?></b> results</p>

<? if (count($invoices) > 0) { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th class="center" width="20"></th>
		<th class="center" width="80">Issued</th>
		<th class="center" width="80">Due</th>
		<th class="center">Inv #</th>
		<th class="center">PO #</th>
		<th>Client Name</th>
		<th>Invoice Title</th>
		<th class="center">Amount</th>
		<th>Issued By</th>
		<th class="center" width="120">Status</th>
		<th class="center" width="40">View</th>
		<th class="center" width="40">Email</th>
	</tr>
</thead>
<tbody>
<? foreach($invoices as $invoice) { 
	$client = modules::run('client/get_client', $invoice['client_id']);
	$user = modules::run('user/get_user', $invoice['issued_by']);
?>
	<tr>
		<td><input type="checkbox" />
		</td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($invoice['issued_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($invoice['issued_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($invoice['issued_date']));?></span>
		</td>
		<td class="wp-date" width="80">
			<span class="wk_day"><?=date('D', strtotime($invoice['due_date']));?></span>
			<span class="wk_date"><?=date('d', strtotime($invoice['due_date']));?></span>
			<span class="wk_month"><?=date('M', strtotime($invoice['due_date']));?></span>
		</td>
		<td><?=$invoice['invoice_number'];?></td>
		<td><?=$invoice['po_number'];?></td>
		<td><?=$client['company_name'];?></td>
		<td><?=$invoice['title'];?></td>
		<td class="center">$<?=money_format('%i', $invoice['total_amount']);?></td>
		<td><?=$user['first_name'] . ' ' . $user['last_name'];?></td>
		<td class="center" id="invoice-status-<?=$invoice['invoice_id'];?>">
			<?=modules::run('invoice/menu_dropdown_status', $invoice['invoice_id']);?>
		</td>
		<td class="center"><a href="<?=base_url();?>invoice/view/<?=$invoice['invoice_id'];?>" target="_blank"><i class="fa fa-eye"></i></a></td>
		<td class="center"><a><i class="fa fa-envelope-o"></i></a></td>
	</tr>
<? } ?>
</tbody>
</table>
<? } ?>
<script>
function mark_as_paid(invoice_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/mark_as_paid",
		data: {invoice_id: invoice_id},
		success: function(html) {
			$('#invoice-status-' + invoice_id).html(html);
		}
	})
}
function mark_as_unpaid(invoice_id) {
	$.ajax({
		type: "POST",
		url: "<?=base_url();?>invoice/ajax/mark_as_unpaid",
		data: {invoice_id: invoice_id},
		success: function(html) {
			$('#invoice-status-' + invoice_id).html(html);
		}
	})
}
</script>