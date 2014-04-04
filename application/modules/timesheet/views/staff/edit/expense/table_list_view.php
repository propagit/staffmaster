<? if ((!isset($expenses) || !$expenses) && (count($paid_expenses) == 0)) { ?>
<div class="alert alert-warning"><b>No expenses.</b> Use the form below to add expense</div>
<? } else { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th>Description</th>
		<th class="center" width="100">Staff Cost</th>
		<th class="center" width="80">Tax</th>
		<td class="center" width="40"></td>
	</tr>
</thead>
<tbody>
	<? $i = 0; foreach($expenses as $expense) { ?>
	<tr>
		<td><?=$expense['description'];?></td>
		<td class="center">$<?=money_format('%i', $expense['staff_cost']);?></td>
		<td class="center"><?=modules::run('common/reverse_field_gst', $expense['tax'], true);?></td>
		<td class="center"><a onclick="delete_expense(<?=$timesheet_id;?>, <?=$i;?>)"><i class="fa fa-times"></i></a></td>
	</tr>
	<? $i++; } ?>
	<? if (count($paid_expenses) > 0) { ?>
	<tr class="success">
		<th colspan="4">Paid Expenses</th>
		<th class="center"><a href="<?=base_url();?>expense/view/<?=$paid_expenses[0]['timesheet_id'];?>" target="_blank"><i class="fa fa-eye"></i></a></th>
	</tr>
	<? foreach($paid_expenses as $expense) { $tax = 1; if ($expense['tax'] == GST_ADD) { $tax = 1.1; } ?>
	<tr class="success">
		<td><?=$expense['description'];?></td>
		<td class="center">$<?=$expense['staff_cost'] * $tax;?></td>
		<td class="center">$<?=$expense['client_cost'] * $tax;?></td>
		<td class="center"><?=modules::run('common/reverse_field_gst', $expense['tax']);?></td>
		<td class="center"></td>
	</tr>
	<? } } ?>
</tbody>
</table>
</div>
<? } ?>