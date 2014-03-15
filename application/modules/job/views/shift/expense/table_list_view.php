<? if (!isset($expenses) || !$expenses) { ?>
<div class="alert alert-warning"><b>No expenses.</b> Use the form below to add expense</div>
<? } else { ?>
<div class="table-responsive">
<table class="table table-bordered table-hover table-middle" width="100%">
<thead>
	<tr>
		<th>Description</th>
		<th class="center">Staff Cost</th>
		<th class="center">Client Cost</th>
		<th class="center">Tax</th>
		<td class="center" width="40"></td>
	</tr>
</thead>
<tbody>
	<? $i = 0; foreach($expenses as $expense) { ?>
	<tr>
		<td><?=$expense['description'];?></td>
		<td class="center">$<?=$expense['staff_cost'];?></td>
		<td class="center">$<?=$expense['client_cost'];?></td>
		<td class="center"><?=modules::run('common/reverse_field_gst', $expense['tax']);?></td>
		<td class="center"><a onclick="delete_expense(<?=$shift_id;?>, <?=$i;?>)"><i class="fa fa-times"></i></a></td>
	</tr>
	<? $i++; } ?>
</tbody>
</table>
</div>
<? } ?>