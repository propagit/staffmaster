<? $tax = 1; if ($expense['tax'] == GST_ADD) { $tax = 1.1; } ?>
<tr id="expense-<?=$expense['expense_id'];?>">
	<td class="center"><input type="checkbox" class="selected_expense" value="<?=$expense['expense_id'];?>" /></td>
	<td class="wp-date" width="80">
		<span class="wk_day"><?=date('D', strtotime($expense['job_date']));?></span>
		<span class="wk_date"><?=date('d', strtotime($expense['job_date']));?></span>
		<span class="wk_month"><?=date('M', strtotime($expense['job_date']));?></span>
	</td>
	<td><?=$expense['staff_name'];?></td>
	<td><?=$expense['company_name'];?></td>
	<td><?=$expense['job_name'];?></td>
	<td><?=$expense['description'];?></td>
	<td class="center">$<?=money_format('%i', $expense['staff_cost'] * $tax);?></td>
	<td class="center"><?=modules::run('expense/menu_dropdown_status', $expense['expense_id']);?></td>
	<td class="wp-date" width="80">
		<? if ($expense['paid_on'] != NULL) { ?>
		<span class="wk_day"><?=date('D', strtotime($expense['paid_on']));?></span>
		<span class="wk_date"><?=date('d', strtotime($expense['paid_on']));?></span>
		<span class="wk_month"><?=date('M', strtotime($expense['paid_on']));?></span>
		<? } ?>
	</td>
</tr>